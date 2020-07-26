<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'author' => ['required'],
        ]);

        \App\Book::create($data);
    }

    public function update(Request $request, \App\Book $book)
    {
        $data = $request->validate([
            'title' => ['required'],
            'author' => ['required'],
        ]);

        $book->update($data);
    }
}
