<?php

namespace App\Http\Controllers;

use App\Events\PriceChangeDetected;
use App\Http\Requests\EntryUpdateRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Models\distributer;
use App\Models\order;
use App\Models\order_entry;
use App\Models\Price;
use App\Models\PriceChange;
use App\Models\product;
use App\Models\sale;
use App\Models\stock;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index(){
        $orders = order::all();
        $distributers = distributer::all();
        return view('orders', ["orders"=> $orders, "distributers"=> $distributers]);
    }
    function view(Request $request, order $id){
        $entries = $id->entries;
        $products = product::all();
        return view('view_orders', [
            "entries"=>$entries,
            "products"=>$products,
            "order" => $id
        ]);
    }
    function update_entry(EntryUpdateRequest $request, order_entry $id){
        $validated = $request->validated();
//        dd($validated["product_id"]);
        $id->update([
            "product_id" => $validated["product_id"],
            "retail_price" => $validated["price"],
            "qty" => $validated["qty"]
        ]);
        return redirect()->action([OrderController::class, "view"], ["id"=>$id->order->id]);
    }
    function delete(Request $request, order_entry $id){
        $id->delete();
        return view('orders');
    }
    function add(OrderCreateRequest $request){
            $order = new order([
                "distributer_id"=> $request->validated()["distributer"]
            ]);
            $order->save();
            session()->put("order", $order->id);
            return redirect()->action([OrderController::class, "add_entries"], ["id"=> $order->id]);
    }
    function add_entries(){
        $products = product::all();
        return view('create_order_entries', [
            "products" => $products
        ]);
    }
    function store_entries(Request $request, order $id){
        $entries = json_decode($request->input("data"), true);
        $changes = array();
        foreach ($entries as $entry){
            $entry_object = new order_entry();
            $entry_object->order_id = $id->id;
            $entry_object->product_id = $entry["product"] ;
            $entry_object->qty = $entry["qty"];
            $entry_object->retail_price = $entry["price"] ;
            $product_price = Price::where("product_id", $entry["product"])->first()->sale_price;
            if($product_price !== $entry["price"]){
                $change = PriceChange::create([
                    "product_id" => $entry["product"],
                    "from" => $product_price,
                    "to" => $entry["price"],
                ]);
                array_push($changes, $change);
            }
            $entry_object->save();
        }
        $this->update_stock($entries);
        if( count($changes) !== 0 ){
//           foreach ($changes as $change){
//               PriceChangeDetected::dispatch($change);
//           }
            return  view("changed_entries", ["changes"=> $changes]);
        }
        return redirect()->action([OrderController::class, "view"], ["id"=>$id->id]);
    }
    protected function  update_stock ($entries){
       foreach ($entries as $entry){
           $product = product::find($entry["product"]);
           $stocks = stock::where("product_id", $product->id)->get();
           if(empty($stocks)){
               $stock = stock::create([
                   "product_id"=> $entry["product"],
                   "retail_price" => $entry["price"],
                   "qty" => $entry["qty"]
               ]);
           }
           else{
               $stock = $stocks[0];
               $qty = $stock->qty;
               $stock->update([
                   "retail_price" => $entry["price"],
                   "qty" => $qty + $entry["qty"]
               ]);
           }
       }
    }

}
