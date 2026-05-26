<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','name','slug','description','price','stock','image','brand','status','tags'];
    protected $casts = ['tags' => 'array'];

    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }

    public function getAvgRatingAttribute() {
        return $this->reviews()->avg('rating') ?? 0;
    }
}

// php artisan make:controller Api/AuthController
// php artisan make:controller Api/ProductController --resource
// php artisan make:controller Api/CategoryController --resource
// php artisan make:controller Api/OrderController --resource
// php artisan make:controller Api/CartController
// php artisan make:controller Api/ReviewController
// php artisan make:controller Api/AdminController
// php artisan make:controller Api/MakeupApiController
// php artisan make:controller Api/ShippingController
// php artisan make:controller GatewayController
// php artisan make:controller Frontend/ShopController