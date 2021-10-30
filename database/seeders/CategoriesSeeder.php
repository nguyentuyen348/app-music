<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = "Nhạc Trẻ";
        $category->save();

        $category = new Category();
        $category->name = "Trữ Tình";
        $category->save();

        $category = new Category();
        $category->name = "Remix Việt";
        $category->save();

        $category = new Category();
        $category->name = "Rap Việt";
        $category->save();

        $category = new Category();
        $category->name = "Cách Mạng";
        $category->save();

        $category = new Category();
        $category->name = "Pop";
        $category->save();

        $category = new Category();
        $category->name = "Rock";
        $category->save();

        $category = new Category();
        $category->name = "Electronica/Dance";
        $category->save();

        $category = new Category();
        $category->name = "Country";
        $category->save();

        $category = new Category();
        $category->name = "Blues/Jazz";
        $category->save();

        $category = new Category();
        $category->name = "EDM";
        $category->save();

        $category = new Category();
        $category->name = "NCS";
        $category->save();

    }
}
