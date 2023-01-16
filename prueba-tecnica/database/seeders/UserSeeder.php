<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name'              => 'Test',
            'last_name'         => 'User',
            'identification'    => '123456',
            'email'             => 'test@example.com',
            'country'           => 'Colombia',
            'address'           => 'Cra 18 # 22-45',
            'category_id'       =>  1,
            'phone'             => '3016789441'
        ]);
    }
}
