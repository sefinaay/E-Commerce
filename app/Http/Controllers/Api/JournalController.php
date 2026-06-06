<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    // ── PUBLIC: Daftar artikel published ──────────────
    public function index(Request $request)
    {
        $q = Journal::with('author:id,name')
            ->published();

        if ($request->category) {
            $q->where('category', $request->category);
        }
        if ($request->search) {
            $q->where('title', 'like', "%{$request->search}%");
        }

        $journals = $q->latest('published_at')
            ->paginate($request->per_page ?? 9);

        // Tambahkan full URL untuk cover_image
        $journals->getCollection()->transform(function($journal) {
            if ($journal->cover_image && !filter_var($journal->cover_image, FILTER_VALIDATE_URL)) {
                $journal->cover_image = asset($journal->cover_image);
            }
            return $journal;
        });

        return response()->json(['success' => true, 'data' => $journals]);
    }

    // ── PUBLIC: Detail artikel ─────────────────────────
    public function show($slug)
    {
        $journal = Journal::with('author:id,name')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Tambahkan full URL untuk cover_image
        if ($journal->cover_image && !filter_var($journal->cover_image, FILTER_VALIDATE_URL)) {
            $journal->cover_image = asset($journal->cover_image);
        }

        // Related articles
        $related = Journal::published()
            ->where('id', '!=', $journal->id)
            ->where('category', $journal->category)
            ->latest('published_at')
            ->take(3)
            ->get(['id', 'title', 'slug', 'excerpt', 'cover_image', 'category', 'read_time', 'published_at']);

        // Tambahkan full URL untuk related articles
        $related->transform(function($item) {
            if ($item->cover_image && !filter_var($item->cover_image, FILTER_VALIDATE_URL)) {
                $item->cover_image = asset($item->cover_image);
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $journal,
            'related' => $related,
        ]);
    }

    // ── ADMIN: Semua artikel (draft + published) ───────
    public function adminIndex(Request $request)
    {
        $journals = Journal::with('author:id,name')
            ->latest()
            ->paginate(15);

        return response()->json(['success' => true, 'data' => $journals]);
    }

    // ── ADMIN: Buat artikel baru (UBAH INI) ───────────────────────
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'cover_image' => 'nullable',
            'category' => 'required|string',
            'read_time' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published',
        ]);

        $v->after(function ($validator) use ($request) {
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $imageRules = Validator::make(['cover_image' => $file], [
                    'cover_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                ]);
                if ($imageRules->fails()) {
                    $validator->errors()->merge($imageRules->errors());
                }
            } elseif ($request->filled('cover_image')) {
                if (!filter_var($request->input('cover_image'), FILTER_VALIDATE_URL)) {
                    $validator->errors()->add('cover_image', 'The cover image must be a valid URL or uploaded image.');
                }
            }
        });

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $v->errors(),
            ], 422);
        }

        $data = [
            'user_id' => auth('api')->id(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')) . '-' . uniqid(),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'read_time' => $request->input('read_time', 5),
            'status' => $request->input('status'),
            'published_at' => $request->input('status') === 'published' ? now() : null,
        ];

        if ($request->filled('cover_image') && !$request->hasFile('cover_image')) {
            $data['cover_image'] = $request->input('cover_image');
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('journals', $filename, 'public');
            $data['cover_image'] = '/storage/' . $path;
        }

        $journal = Journal::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dibuat',
            'data' => $journal,
        ], 201);
    }

    // ── ADMIN: Update artikel (UBAH INI) ──────────────────────────
    public function update(Request $request, $id)
    {
        $journal = Journal::findOrFail($id);

        $v = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string|max:500',
            'cover_image' => 'nullable',
            'category' => 'sometimes|string',
            'read_time' => 'nullable|integer|min:1',
            'status' => 'sometimes|in:draft,published',
        ]);

        $v->after(function ($validator) use ($request) {
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $imageRules = Validator::make(['cover_image' => $file], [
                    'cover_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                ]);
                if ($imageRules->fails()) {
                    $validator->errors()->merge($imageRules->errors());
                }
            } elseif ($request->filled('cover_image')) {
                if (!filter_var($request->input('cover_image'), FILTER_VALIDATE_URL)) {
                    $validator->errors()->add('cover_image', 'The cover image must be a valid URL or uploaded image.');
                }
            }
        });

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $data = $request->only(['title', 'excerpt', 'content', 'category', 'read_time', 'status']);

        // Set published_at saat pertama publish
        if ($request->status === 'published' && $journal->status === 'draft') {
            $data['published_at'] = now();
        }

        if ($request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        }

        if ($request->filled('cover_image') && !$request->hasFile('cover_image')) {
            $data['cover_image'] = $request->input('cover_image');
        }

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama
            if ($journal->cover_image && file_exists(public_path($journal->cover_image))) {
                $oldPath = str_replace('/storage/', '', $journal->cover_image);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . Str::slug($request->title ?? $journal->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('journals', $filename, 'public');
            $data['cover_image'] = '/storage/' . $path;
        }

        $journal->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel diperbarui',
            'data' => $journal,
        ]);
    }

    // ── ADMIN: Hapus artikel (UBAH INI) ───────────────────────────
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);

        // Hapus file gambar
        if ($journal->cover_image && file_exists(public_path($journal->cover_image))) {
            $oldPath = str_replace('/storage/', '', $journal->cover_image);
            Storage::disk('public')->delete($oldPath);
        }

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel dihapus',
        ]);
    }

    // ── ADMIN: Toggle publish/draft ────────────────────
    public function toggleStatus($id)
    {
        $journal = Journal::findOrFail($id);
        $newStatus = $journal->status === 'published' ? 'draft' : 'published';

        $journal->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Artikel di-$newStatus",
            'data' => $journal,
        ]);
    }
}
