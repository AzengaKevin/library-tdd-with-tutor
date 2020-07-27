<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function store()
    {
        $book = \App\Book::create($this->validateRequest());

        return redirect($book->path());
    }

    public function update(\App\Book $book)
    {
        $book->update($this->validateRequest());

        return redirect($book->path());
    }

    public function destroy(\App\Book $book)
    {
        $book->delete();

        return redirect('/books');
    }

    private function validateRequest()
    {
        return request()->validate([
            'title' => ['required'],
            'author_id' => ['required'],
        ]);
    }
}
