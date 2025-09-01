<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(['email'=>'admin@example.com'],[
            'name'=>'Admin', 'password'=>bcrypt('password')
        ]);
        Customer::updateOrCreate(['email'=>'customer@example.com'],[
            'name'=>'Customer', 'password'=>bcrypt('password')
        ]);
        Product::factory()->count(10)->create();
    }
}
