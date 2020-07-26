<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        \App\Author::create(request()->only(['name', 'dob']));
    }
}
