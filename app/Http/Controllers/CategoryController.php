<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index(){
        $categories = categories::all();
        return view('categories', ["categories"=>$categories]);
    }
    function store (StoreCategoryRequest $request){
        categories::create($request->validated());
        return redirect()->action([CategoryController::class, "index"]);
    }
    function update(StoreCategoryRequest $request, categories $id){
        $id->update($request->validated());
        return redirect()->action([CategoryController::class, "index"]);
    }

    function delete(Request $request, categories $id){
        $id->delete();
        return redirect()->action([CategoryController::class, "index"]);
    }
    function storeFromEp (StoreCategoryRequest $request){
        categories::create($request->validated());
        return redirect()->action([ExpenseController::class, "index"]);
    }
}
