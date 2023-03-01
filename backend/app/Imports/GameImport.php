<?php

namespace App\Imports;

use App\Models\GameModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class GameImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation
{
    use SkipsFailures;
    public function model(array $row)
    {
        $gameModel=new GameModel([
            'name' => $row['name'],
            'description' => $row['description'],
            'image' => $row['image'],
            'rating' => $row['rating'],
            'status' => $row['status'],
        ]);
        $game['categories'] = explode(',', $row['categories']);
        // dd( $game['categories']);
        // $game_id = GameModel::latest()->first();
        foreach ($game['categories'] as $category) {
            DB::table('category_game')->insert([
                'game_id' => $row['id'],
                'category_id' => $category
            ]);
        }
        
        return $gameModel;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|unique:games,name',
            '*.name' => 'required|unique:games,name',
            // 'name' => 'required|min:5|unique:games,name',
            // '*.name' => 'required|min:5|unique:games,name',
        ];
    }
}
