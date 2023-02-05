<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryModel::all();
    }

    public function add(Request $request)
    {
        $messages = [
            'name.required' => 'Please type category name',
        ];
        $this->validate($request, [
            'name' => 'required',
        ],$messages);
        $category=new CategoryModel();
        $category->name=$request->name;
        $category->save();

        return response()->json([
            'message'=>'Add Success',
        ], 200);
    }

    public function store(Request $request,$id)
    {
        $messages = [
            'name.required' => 'Please type category name',
        ];
        $this->validate($request, [
            'name' => 'required',
        ],$messages);
        $category=CategoryModel::find($id);
        $category->name=$request->name;
        $category->save();

        return response()->json([
            'message'=>'Update success',
        ], 200);
    }
}
