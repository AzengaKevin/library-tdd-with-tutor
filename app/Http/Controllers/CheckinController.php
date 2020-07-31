<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function update(Request $request, Book $book)
    {
        try{

            $book->checkin($request->user());
            
        }catch(\Exception $e){
            return response([], 404);
        }
    }
}
