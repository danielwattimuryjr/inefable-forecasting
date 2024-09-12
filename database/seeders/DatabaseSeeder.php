<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nama' => 'Test User',
            'username' => 'test.user',
            'email' => 'test@example.com',
            'role' => 'direktur_operasional'
        ]);

        $this->call([
            ProductCategoriesSeeder::class,
            ProductsSeeder::class,
            SalesSeeder::class
        ]);
    }
}
