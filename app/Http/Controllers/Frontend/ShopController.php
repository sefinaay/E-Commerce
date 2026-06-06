<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }
    public function shop()
    {
        return view('frontend.shop');
    }
    public function product($id)
    {
        return view('frontend.product', compact('id'));
    }
    public function cart()
    {
        return view('frontend.cart');
    }
    public function checkout()
    {
        return view('frontend.checkout');
    }
    public function orders()
    {
        return view('frontend.orders');
    }
    public function loginPage()
    {
        return view('frontend.auth.login');
    }
    public function registerPage()
    {
        return view('frontend.auth.register');
    }
    public function adminPage()
    {
        return view('frontend.admin.dashboard');
    }
    public function profilePage()
    {
        return view('frontend.profile');
    }
    public function discoverPage()
    {
        return view('frontend.discover');
    }
    public function journalPage()
    {
        return view('frontend.journal.index');
    }
    public function journalDetail($slug)
    {
        return view('frontend.journal.detail', compact('slug'));
    }
    public function searchPage()
    {
        return view('frontend.search');
    }

    public function aboutPage()
    {
        return view('frontend.about');
    }
    public function wishlistPage()
    {
        return view('frontend.wishlist');
    }
}

