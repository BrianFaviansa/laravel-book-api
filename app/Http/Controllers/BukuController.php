<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy("judul", "asc")->get();

        return response()->json([
            "message" => "Books retrieved successfully",
            "data" => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newBook = new Buku;

        $rules = [
            "judul" => "required|min:5",
            "pengarang" => "required|min:5",
            "tanggal_publikasi" => "required|date",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to create book",
                "error" => $validator->errors()
            ], 400);
        }

        $newBook->judul = $request->judul;
        $newBook->pengarang = $request->pengarang;
        $newBook->tanggal_publikasi = $request->tanggal_publikasi;

        $newBook->save();

        return response()->json([
            "message" => "Book created successfully",
            "book" => $newBook,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return response()->json([
            "message" => "Book retrieved successfully",
            "book" => $buku
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            "judul" => "sometimes|required|min:5",
            "pengarang" => "sometimes|required|min:5",
            "tanggal_publikasi" => "sometimes|required|date",
        ]);

        $buku->fill($validatedData);
        $buku->save();

        return response()->json([
            "message" => "Book updated successfully",
            "book" => $buku,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        try {
            $buku->delete();

            return response()->json([
                "message" => "Book deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "An error occurred while deleting the book"
            ], 500);
        }
    }
}
