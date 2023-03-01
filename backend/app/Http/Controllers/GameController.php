<?php

namespace App\Http\Controllers;

use App\Exports\GameExport;
use App\Models\GameModel;
use App\Imports\GameImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GameController extends Controller
{
    public function index()
    {
        return GameModel::with(['categories' => function ($query) {
            $query->orderBy('category_id');
        }])->orderBy('name', 'asc')->paginate(12);
    }
    public function search(Request $request)
    {
        return GameModel::Where(function ($q) use ($request) {
            $q->when($request->filled('name'), function ($q) use ($request) {
                $q->where('name', 'LIKE', $request->name . '%')->orWhere('name', 'LIKE', "%" . " " . $request->name . '%');
            })
                ->when($request->filled('status'), function ($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->filled('category'), function ($q) use ($request) {
                    $q->whereHas('categories', fn ($q) =>
                    $q->where('category_id', $request->category));
                });
        })->with(['categories' => function ($query) {
            $query->orderBy('category_id');
        }])->orderBy($request->orderBy, $request->sortOrder)->paginate(12)->appends($request->except(['page', '_token']));
    }

    public function add(Request $request)
    {
        $messages = [
            'name.required' => 'Please type game name',
            'categories.required' => 'Please select category',
        ];
        $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',
        ], $messages);
        $game = new GameModel();
        $game->name = $request->name;
        $game->description = $request->description;
        $game->rating = $request->rating;
        $game->image = $request->image;
        $game->status = "3";
        $game->save();
        if ($request->categories) {
            $game_id = GameModel::latest()->first();
            foreach ($request->categories as $category) {
                DB::table('category_game')->insert([
                    'game_id' => $game_id->id,
                    'category_id' => $category["id"]
                ]);
            }
        }
        return response()->json([
            'message' => "Add Success",
        ], 200);
    }
    public function store(Request $request, $id)
    {
        $messages = [
            'name.required' => 'Please type game name',
            'categories.required' => 'Please select category',
        ];
        $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',
        ], $messages);
        $game = GameModel::find($id);
        $game->name = $request->name;
        $game->description = $request->description;
        $game->rating = $request->rating;
        $game->image = $request->image;
        $game->status = $request->status;
        $game->save();
        if ($request->categories) {
            DB::table('category_game')->where('game_id', $id)->delete();
            foreach ($request->categories as $category) {
                DB::table('category_game')->insert([
                    'game_id' => $id,
                    'category_id' => $category["id"]
                ]);
            }
        }

        return response()->json([
            'message' => "Update Success",
        ], 200);
    }

    public function import(Request $request)
    {
        $messages = [
            'file.required' => 'Please import file',
            'file.mimes' => 'File not correct ',
        ];
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv',
        ], $messages);
        // $import = new GameImport();
        // $import->import($request->file);
        
        Excel::import(new GameImport, $request->file);


        // $file = $request->file;

        // $rows = Excel::toArray([], $file);

        // $headings = $rows[0][0];
        // dd($headings);

        // unset($rows[0][0]);

        // foreach ($rows[0] as $row) {
        //     $game = [];

        //     foreach ($headings as $key => $value) {
        //         $game[$value] = $row[$key];
        //     }

        //     $gameModel = new GameModel();
        //     $gameModel->name = $game['name'];
        //     $gameModel->description =$game['description'];
        //     $gameModel->image = $game['image'];
        //     $gameModel->rating = $game['rating'];
        //     $gameModel->status = $game['status'];
        //     $gameModel->save();

        //     $game['categories'] = explode(',', $game['categories']);

        //     $game_id = GameModel::latest()->first();
        //     foreach ($game['categories'] as $category) {
               
        //         DB::table('category_game')->insert([
        //             'game_id' => $game_id->id,
        //             'category_id' => $category["id"]
        //         ]);
        //     }            
        // }
        return response()->json([
            'message' => "Import Success",
        ], 200);
    }
    public function export(Request $request)
    {
        $listGame = GameModel::Where(function ($q) use ($request) {
            $q->when($request->filled('name'), function ($q) use ($request) {
                $q->where('name', 'LIKE', $request->name . '%')->orWhere('name', 'LIKE', "%" . " " . $request->name . '%');
            })
                ->when($request->filled('status'), function ($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->filled('category'), function ($q) use ($request) {
                    $q->whereHas('categories', fn ($q) =>
                    $q->where('category_id', $request->category));
                });
        })->orderBy($request->orderBy, $request->sortOrder)->with('categories')->get();

        if ($listGame->count() == 0) {
            return response()->json([
                'message' => "Import Failed",
                'status' => 'error'
            ], 200);
        }
        return Excel::download(new GameExport($listGame), 'List Game-' . time() . '.xls');
    }
}
