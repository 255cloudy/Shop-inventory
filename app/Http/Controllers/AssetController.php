<?php

namespace App\Http\Controllers;

use App\Models\asset_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AssetController extends Controller
{
    function index(){
        $assets = asset_register::all();
        return view('asset', ['assets'=> $assets]);
    }
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:20',
            'condition' => 'required',
            'qty' => 'required'
        ]);
        if($validator->fails()){
            redirect()
                ->action([AssetController::class, "index"])
                ->withErrors($validator, "create")
                ->withInput();
        }
        $validated = $validator->validated();
        $asset = new asset_register();
        $asset->name = $validated['name'];
        $asset->condition = $validated['condition'];
        $asset->qty = $validated['qty'];
        $asset->save();

        return  redirect()->action([AssetController::class, "index"]);
    }
    function update(Request $request, asset_register $id){

        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:20',
            'condition' => 'required',
            'qty' => 'required'
        ]);
        if($validator->fails()){
            redirect()
                ->action([AssetController::class, "index"])
                ->withErrors($validator, "update")
                ->withInput();
        }
        $validated = $validator->validated();
        $id->name = $validated['name'];
        $id->condition = $validated['condition'];
        $id->qty = $validated['qty'];
        $id->save();
        return  redirect()->action([AssetController::class, "index"]);
    }
    function delete(Request $request, asset_register $id){
        $id->delete();
        return redirect()->action([AssetController::class, "index"]);
    }
}

