<?php

namespace Database\Seeders;

use App\Models\GameModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        GameModel::truncate();
        Schema::enableForeignKeyConstraints();    

        Schema::disableForeignKeyConstraints();
        DB:: table('category_game')->truncate();
        Schema::enableForeignKeyConstraints();   
    }
}
