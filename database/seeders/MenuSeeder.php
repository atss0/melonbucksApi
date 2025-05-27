<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Store;
use App\Models\Table;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Mağaza Oluştur
        $store = Store::create([
            'name' => 'MelonBucks Merkez',
            'address' => 'Çorum / Merkez',
            'latitude' => 40.565406,
            'longitude' => 34.962829,
        ]);

        // Masalar (5 adet)
        foreach (range(1, 5) as $i) {
            Table::create([
                'store_id' => $store->id,
                'name' => "Masa $i",
                'qr_code' => "MELON-QR-00$i",
            ]);
        }

        // Menü Kategorileri
        $drinks = MenuCategory::create(['name' => 'İçecekler']);
        $foods = MenuCategory::create(['name' => 'Yemekler']);
        $desserts = MenuCategory::create(['name' => 'Tatlılar']);

        // Menü Ürünleri
        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $drinks->id,
            'name' => 'Buzlu Latte',
            'description' => 'Soğuk espresso ve süt',
            'price' => 55.00,
            'image' => 'menu/latte.jpg',
            'is_popular' => true,
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $foods->id,
            'name' => 'Tavuk Wrap',
            'description' => 'Izgara tavuk ve sebzeli dürüm',
            'price' => 85.00,
            'image' => 'menu/wrap.jpg',
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $desserts->id,
            'name' => 'Cheesecake',
            'description' => 'Frambuaz soslu',
            'price' => 65.00,
            'image' => 'menu/cheesecake.jpg',
            'is_popular' => true,
        ]);
    }
}