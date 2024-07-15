<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            [
                'id' => 1,
                'category_name'=>'Ban',
            ],
            [
                'id' => 2,
                'category_name'=>'Oli',
            ], 
            [
                'id' => 3,
                'category_name'=>'Kampas Rem',
            ], 
            [
                'id' => 4,
                'category_name'=>'Busi',
            ], 
            [
                'id' => 5,
                'category_name'=>'Kampas Kopling',
            ], 
            [
                'id' => 6,
                'category_name'=>'Aki',
            ], 
            [
                'id' => 7,
                'category_name'=>'Radiator',
            ], 
            [
                'id' => 8,
                'category_name'=>'Timing Belt',
            ], 
            [
                'id' => 9,
                'category_name'=>'Shock Absorber',
            ], 
            [
                'id' => 10,
                'category_name'=>'Bearing Roda',
            ], 
        ];
  
        foreach ($category as $key => $value) {
            Category::create($value);
        }
    }
}
