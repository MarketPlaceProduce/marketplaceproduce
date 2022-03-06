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
                'contact_email' => 'john@bigtruck.com'
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Carrots',
                'source' => 'Vinyards',
                'source_price' => 0.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Potatoes',
                'source' => 'Vinyards',
                'source_price' => 0.99,
                'default_markup' => 0.30,
            ]);

        DB::table('products')
            ->insert([
                'name' => 'Brocolli',
                'source' => 'Vinyards',
                'source_price' => 0.99,
                'default_markup' => 0.30,
            ]);
    }
}
