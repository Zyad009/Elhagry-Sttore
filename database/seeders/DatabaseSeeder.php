<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Models\PickupPoint;
use App\Models\SaleOfficer;
use App\Models\CustomerService;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            MessageSeeder::class,
        ]);

        User::factory(100)->create();
        PickupPoint::factory(25)->create();
        Admin::factory(1)->create();
        SaleOfficer::factory(25)->create();
        City::factory(1)->create();
        Area::factory(8)->create();
        CustomerService::factory(6)->create();
        Product::factory(50)->create();
        Order::factory(20)->create();
    }
}
