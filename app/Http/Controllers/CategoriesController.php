<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoriesController extends Controller
{
    public function index() {
        return view('expense.categories');
    }

    public function addCategory(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'status' => 'success',
            'last_id' => $category->id,
            'created_at' => $category->created_at
        ]);
    }

    public function getCategory() {
        $category = Category::all();
        return response()->json($category);
    }

    public function deleteCategory(Request $request) {
        Category::destroy($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function updateCategory(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'status' => 'success',
            'last_id' => $category->id
        ]);

    }

}
