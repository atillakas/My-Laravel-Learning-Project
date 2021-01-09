<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->insert([
            ['product_id' => 1, 'category_id' => 1, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 1, 'category_id' => 2, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 1, 'category_id' => 3, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 1, 'category_id' => 4, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 2, 'category_id' => 1, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 2, 'category_id' => 2, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 2, 'category_id' => 3, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
            ['product_id' => 3, 'category_id' => 5, 'created_at' => '2021-01-07 22:51:46', 'updated_at' => '2021-01-08 22:51:46'],
        ]);
    }
}
