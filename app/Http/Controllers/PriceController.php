<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepriceRequest;
use App\Http\Requests\UpdatepriceRequest;
use App\Models\Price;
use App\Models\product;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view("prices", ["prices"=>Price::all(), "products"=> product::all()]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepriceRequest  $request
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatepriceRequest $request, price $id)
    {
        $validated = $request->validated();
        $id->update([
            "sale_price" => $validated["price"]
        ]);
        return redirect()->action([PriceController::class, "index"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(price $price)
    {
        //
    }
}
