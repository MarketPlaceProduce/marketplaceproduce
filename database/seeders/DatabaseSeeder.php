<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'name' => 'Admin',
                'email' => 'admin@marketplaceproduce.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);

        DB::table('customers')
            ->insert([
                'name' => 'Big Truck Tacos',
                'address' => "530 NW 23rd St\nOklahoma City, OK 73103",
                'contact_name' => 'John Doe',
                'contact_phone' => '+1 (555) 555-5555',
                'contact_email' => 'john@bigtruck.com',
                'active' => 1
            ]);

        DB::table('customer_user')
            ->insert([
                'customer_id' => 1001,
                'user_id' => 1
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Carrots',
                'image' => 'https://www.svgrepo.com/show/95357/carrot.svg',
                'source' => 'Vinyards',
                'source_price' => 0.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Potatoes',
                'image' => 'https://www.svgrepo.com/show/398113/potato.svg',
                'source' => 'Vinyards',
                'source_price' => 0.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Brocolli',
                'image' => 'https://www.svgrepo.com/show/404889/broccoli.svg',
                'source' => 'Vinyards',
                'source_price' => 1.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Red Bell Pepper',
                'image' => 'https://www.svgrepo.com/show/276187/bell-pepper-bell-pepper.svg',
                'source' => 'Vinyards',
                'source_price' => 1.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Green Bell Pepper',
                'image' => 'https://www.svgrepo.com/show/404831/bell-pepper.svg',
                'source' => 'Vinyards',
                'source_price' => 1.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Bananas',
                'image' => 'https://www.svgrepo.com/show/227289/banana.svg',
                'source' => 'Vinyards',
                'source_price' => 2.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Apples',
                'image' => 'https://www.svgrepo.com/show/1731/apple.svg',
                'source' => 'Vinyards',
                'source_price' => 2.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Oranges',
                'image' => 'https://www.svgrepo.com/show/108487/orange.svg',
                'source' => 'Vinyards',
                'source_price' => 2.99,
                'default_markup' => 0.30,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1001,
                'markup' => 0.31,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1002,
                'markup' => 0.32,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1003,
                'markup' => 0.33,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1004,
                'markup' => 0.34,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1005,
                'markup' => 0.35,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1006,
                'markup' => 0.36,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1007,
                'markup' => 0.37,
            ]);

        DB::table('customer_product')
            ->insert([
                'customer_id' => 1001,
                'product_id' => 1008,
                'markup' => 0.38,
            ]);
    }
}
