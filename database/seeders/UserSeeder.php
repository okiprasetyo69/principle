<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'id' => 1,
                'company_name'=>'Principal',
                'phone_number' => '081312345678',
                'email'=>'principal@example.com',
                'address' => 'Jakarta Pusat',
                'role_id'=> 1,
                'password'=> bcrypt('12345678'),
            ],
            [
                'id' => 2,
                'company_name'=>'Distributor',
                'phone_number' => '088912345678',
                'email'=>'distributor@example.com',
                'address' => 'Bekasi',
                'role_id'=> 2,
                'password'=> bcrypt('12345678'),
            ], 
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
