<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin GlowMart',
            'email'    => 'admin@glowmart.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '08100000001',
        ]);

        // Customer
        User::create([
            'name'     => 'Customer Demo',
            'email'    => 'customer@glowmart.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '08200000002',
        ]);

        // Categories
        $categories = ['Lipstick','Foundation','Eyeshadow','Mascara','Blush','Skincare','Perfume'];
        foreach ($categories as $cat) {
            Category::create(['name'=>$cat,'slug'=>Str::slug($cat),'description'=>"Koleksi $cat terbaik"]);
        }

        // Products
        $lipId = Category::where('name','Lipstick')->first()->id;
        $fndId = Category::where('name','Foundation')->first()->id;

        $products = [
            ['name'=>'Rose Velvet Lip Color','price'=>89000,'brand'=>'Maybelline','stock'=>50,'category_id'=>$lipId,'image'=>'https://d3t32hsnjxo7q6.cloudfront.net/i/991799eb6f12b34d3e4b49e99c4b9d30_ra,w158,h184_pa,w158,h184.png'],
            ['name'=>'Matte Revolution Lipstick','price'=>125000,'brand'=>'Charlotte Tilbury','stock'=>30,'category_id'=>$lipId,'image'=>'https://d3t32hsnjxo7q6.cloudfront.net/i/e1fe3db3618a01d741748a69c0c1e60c_ra,w158,h184_pa,w158,h184.png'],
            ['name'=>'Pro Filt\'r Foundation','price'=>315000,'brand'=>'Fenty Beauty','stock'=>25,'category_id'=>$fndId,'image'=>'https://d3t32hsnjxo7q6.cloudfront.net/i/aafd37eeac81e1e0e8cc1c0b9ee2681b_ra,w158,h184_pa,w158,h184.png'],
            ['name'=>'Stay Matte Foundation','price'=>145000,'brand'=>'Rimmel','stock'=>40,'category_id'=>$fndId,'image'=>'https://d3t32hsnjxo7q6.cloudfront.net/i/9f5fccca5e1e4db8ecc1b9f0e3aadb0a_ra,w158,h184_pa,w158,h184.png'],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['slug'=>Str::slug($p['name']).'-'.uniqid(),'description'=>"Produk berkualitas tinggi dari brand {$p['brand']}."]));
        }
    }
}