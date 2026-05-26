<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = ['name','email','password','role','phone','address','avatar'];
    protected $hidden = ['password','remember_token'];

    public function getJWTIdentifier() { return $this->getKey(); }
    public function getJWTCustomClaims() { return []; }

    public function orders() { return $this->hasMany(Order::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function isAdmin() { return $this->role === 'admin'; }
}
