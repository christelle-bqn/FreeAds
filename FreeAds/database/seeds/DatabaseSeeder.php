<?php

use App\{Category, Interest};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'Electronics', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Home, Garden', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Books, Movies, Music','created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Sporting Goods', 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Cars, Motorcycles', 'created_at' => date("Y-m-d H:i:s")],
        ]);
        // $this->call(UserSeeder::class);
    }
}
