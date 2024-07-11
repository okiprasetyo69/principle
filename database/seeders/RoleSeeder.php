<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'id' => 1,
                'name'=>'Principal',
            ],
            [
                'id' => 2,
                'name'=>'Distributor',
            ], 
        ];
  
        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}
