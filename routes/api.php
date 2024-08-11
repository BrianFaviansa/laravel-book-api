<?php

use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix("v1")->group(function(){
    Route::get("/books", [BukuController::class, "index"]);
    Route::post("/books", [BukuController::class,    "store"]);
    Route::get("/books/{buku}", [BukuController::class, "show"]);
    Route::put("/books/{buku}", [BukuController::class, "update"]);
    Route::delete("/books/{buku}", [BukuController::class, "destroy"]);
});
