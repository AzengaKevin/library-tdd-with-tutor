@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 min-h-screen text-white">

        <div class="w-2/3 mx-auto p-6 shadow">

            <div class="flex justify-between items-center py-3">
                <a href="{{ route('authors.index') }}" class="bg-orange-700 px-4 py-2 rounded">Browse Author</a>
            </div>

            <form action="{{ route('authors.store') }}" class="flex flex-col items-center" method="post">
                <h2 class="text-2xl  text-gray-500">Add New Author</h2>
    
                @csrf
                <div class="pt-4">
                    <input type="text" name="name" id="name" 
                        class="rounded-full px-4 py-2 w-96 focus:outline-none focus:shadow-outline text-gray-400"
                        placeholder="Full Name">
                    @error('name') <p class="text-red-500 text-center mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="pt-4">
                    <input type="date" name="dob" id="dob" 
                        class="rounded-full px-4 py-2 w-96 focus:outline-none focus:shadow-outline text-gray-400" 
                        placeholder="Date of Birth">
                    @error('dob') <p class="text-red-500 text-center mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="pt-4">
                    <button class="px-4 py-3 rounded-full w-96 bg-purple-700 text-white focus:outline-none focus:shadow-outline" type="submit">Add New Author</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection