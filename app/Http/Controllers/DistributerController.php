<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDistributerRequest;
use App\Http\Requests\UpdateDistributerRequest;
use App\Models\distributer;
use Illuminate\Http\Request;

class DistributerController extends Controller
{
    function index(){
        return view('distributers', ["distributers"=> distributer::all()]);
    }
    function update(UpdateDistributerRequest $request, distributer $id){
        $validated = $request->validated();
        $id->update(["name"=> $validated["name"]]);
        return redirect()->action([DistributerController::class, "index"]);
    }
    function create(CreateDistributerRequest $request){
        $name = $request->validated("name");
        $distibuter = new distributer();
        $distibuter->name = $name;
        $distibuter->save();
        return redirect()->action([DistributerController::class, "index"]);
    }
    function delete(Request $request, Distributer $id){
        $id->delete();
        return redirect()->action([DistributerController::class, "index"]);
    }
}
