<?php

namespace Database\Seeders;

use App\Helpers\DataImporter;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataImporter::from(__DIR__ . '/../initialization/categories.csv')->getDataForModel(Category::class);
//        Category::query()->create([
//            'name' => 'courier',
//            'display_name' => 'Курьерские услуги',
//            'icon' => 'courier',
//        ]);
    }
}
