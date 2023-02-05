<?php

namespace App\Imports;

use App\Models\GameModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class GameImport implements ToModel,WithHeadingRow,SkipsOnFailure,WithValidation
{
    use SkipsFailures;
    public function model(array $row)
    {
        return new GameModel([
            'name'=> $row['name'],
            'status'=>$row['status']=="DONE"?1:3
        ]);
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
