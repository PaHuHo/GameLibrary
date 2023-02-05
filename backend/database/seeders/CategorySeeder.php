<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        CategoryModel::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'name' => "Action",
                'color' => "e44e69",
            ],
            [
                'name' => "Open World",
                'color' => "8b6df8",
            ],
            [
                'name' => "Adventure",
                'color' => "31a1f1",
            ],
            [
                'name' => "Horror",
                'color' => "0bba4b",
            ],
            [
                'name' => "Shooter",
                'color' => "C186B8",
            ],
            [
                'name' => "Stealth",
                'color' => "9770EC",
            ],
            [
                'name' => "Fighting",
                'color' => "fb682f",
            ],
            [
                'name' => "Sim",
                'color' => "BFCFDB",
            ],
            [
                'name' => "Survival",
                'color' => "F5DB13",
            ],
            [
                'name' => "Other",
                'color' => "F9D7F9",
            ],
        ];
        // $categories = ["Action", "Open World", "Adventure", "Horror", "Shooter", "Stealth", "Fighting", "Sim", "Sports", "Survival", "Other"];

        foreach ($categories as $category) {
            $cate = new CategoryModel();
            $cate->name = $category['name'];
            $cate->color=$category['color'];
            $cate->save();
        }
    }
}
