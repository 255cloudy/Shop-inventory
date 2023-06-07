<?php

namespace App\Http\Controllers;


use App\Http\Requests\ExpenseStoreRequest;
use App\Models\categories;
use App\Models\expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    function index(){
        $expenses = expense::all();
        $categories = categories::all();
        return view('expense', ["expenses"=>$expenses, "categories"=>$categories]);
    }
    function store(ExpenseStoreRequest $request){
        $validated_data = $request->validated();
        $expense = new expense();
        $expense->name = $validated_data["name"];
        $expense->amount = $validated_data["amount"];
        $expense->category_id = $validated_data["category"];
        $expense->recurring = $validated_data["recurring"];
        $expense->save();
        return redirect()->action([ExpenseController::class, "index"]);
    }
    function update(ExpenseStoreRequest $request, expense $id){
        $id->update($request->validated());
        return redirect()->action([ExpenseController::class, "index"]);
    }

    function delete(Request $request, expense $id){
        $id->delete();
        return redirect()->action([ExpenseController::class, "index"]);
    }
}
