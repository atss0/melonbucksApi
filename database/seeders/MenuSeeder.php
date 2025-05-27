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
        // Mağaza
        $store = Store::create([
            'name' => 'MelonBucks Merkez',
            'address' => 'Çorum / Merkez',
            'latitude' => 40.565406,
            'longitude' => 34.962829,
        ]);

        // Masalar
        foreach (range(1, 5) as $i) {
            Table::create([
                'store_id' => $store->id,
                'name' => "Masa $i",
                'qr_code' => "MELON-QR-00$i",
            ]);
        }

        // Kategoriler
        $drinks = MenuCategory::create(['name' => 'İçecekler']);
        $foods  = MenuCategory::create(['name' => 'Yemekler']);
        $desserts = MenuCategory::create(['name' => 'Tatlılar']);

        // İçecekler
        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $drinks->id,
            'name' => 'Buzlu Latte',
            'description' => 'Soğuk espresso, süt ve buz.',
            'price' => 72.00,
            'image' => 'https://images.unsplash.com/photo-1587734903853-36796baf1f68', // latte
            'is_popular' => true,
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $drinks->id,
            'name' => 'Filtre Kahve',
            'description' => 'Taze çekilmiş filtre kahve.',
            'price' => 48.00,
            'image' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348',
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $drinks->id,
            'name' => 'Portakallı Soğuk Çay',
            'description' => 'Ev yapımı portakallı buzlu çay.',
            'price' => 45.00,
            'image' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b',
        ]);

        // Yemekler
        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $foods->id,
            'name' => 'Tavuk Wrap',
            'description' => 'Izgara tavuk, marul, domates, özel sos.',
            'price' => 98.00,
            'image' => 'https://images.unsplash.com/photo-1601050690185-52f9bafdb7f2',
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $foods->id,
            'name' => 'Köfte Tabağı',
            'description' => 'Ev yapımı köfte, pilav ve salata.',
            'price' => 115.00,
            'image' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092',
            'is_popular' => true,
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $foods->id,
            'name' => 'Vejetaryen Makarna',
            'description' => 'Sebzeli penne makarna, fesleğenli sos.',
            'price' => 92.00,
            'image' => 'https://images.unsplash.com/photo-1603133872874-684f231aa73a',
        ]);

        // Tatlılar
        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $desserts->id,
            'name' => 'Cheesecake',
            'description' => 'Frambuaz soslu klasik cheesecake.',
            'price' => 68.00,
            'image' => 'https://images.unsplash.com/photo-1621272992881-9feebf8a7b1a',
            'is_popular' => true,
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $desserts->id,
            'name' => 'Sufle',
            'description' => 'İçi akışkan çikolatalı sufle.',
            'price' => 58.00,
            'image' => 'https://images.unsplash.com/photo-1586985289688-6d831642b0b0',
        ]);

        MenuItem::create([
            'store_id' => $store->id,
            'category_id' => $desserts->id,
            'name' => 'Tiramisu',
            'description' => 'Klasik İtalyan tatlısı, kahve ve mascarpone.',
            'price' => 72.00,
            'image' => 'https://images.unsplash.com/photo-1589308078050-9720d3c37e35',
        ]);
    }
}