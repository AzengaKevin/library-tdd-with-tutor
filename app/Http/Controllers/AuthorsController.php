<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{

    public function index()
    {
        return view('authors.index', ['authors' => Author::orderBy('dob', 'asc')->get()]);
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store()
    {
        \App\Author::create($this->validateRequest());

        return redirect()->route('authors.index');

    }


    private function validateRequest()
    {
        return request()->validate([
            'name' => ['required'],
            'dob' => ['required'],
        ]);
    }
}
