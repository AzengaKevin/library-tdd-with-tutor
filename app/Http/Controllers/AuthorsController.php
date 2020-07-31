<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        \App\Author::create($this->validateRequest());
    }


    private function validateRequest()
    {
        return request()->validate([
            'name' => ['required'],
            'dob' => ['required'],
        ]);
    }
}
