Route::get('stock/all', [\App\Http\Controllers\StockController::class, 'index'])->name("all-stock");
Route::post('stock/update/{id}', [\App\Http\Controllers\StockController::class, 'update'])->name("update-stock");
