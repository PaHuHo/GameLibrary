<?php

namespace App\Exports;

use App\Models\GameModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GameExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return GameModel::all();
    // }
    public $games;
    public function __construct($games)
    {
        $this->games=$games;
    }
    public function collection()
    {
        $data = [];

        foreach ($this->games as $games) {
            $categories = $games->categories->pluck('id')->implode(', ');

            $data[] = [
                'Id'=>$games->id,
                'name' => $games->name,
                'Description' => $games->description,
                'Image' => $games->image,
                'Rating' => $games->rating,
                'Status' => $games->status,
                'Categories' => $categories,
            ];
        }

        return collect($data);
        //return $this->games;
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Image',
            'Rating',
            'Status',
            'Categories'
        ];
    }
    // public function map($games): array
    // {
    //     $listCategoryArray=[];
    //     foreach($games->Categories as $category){
    //         $listCategoryArray[]=$category->category_id;
    //     }
    //     $listCategory = implode(",", $listCategoryArray);
    //     return [
    //         $games->name,
    //         $games->description,
    //         $games->image,
    //         $games->rating,
    //         $games->status,
    //         1,
    //     ];
    // }
}
