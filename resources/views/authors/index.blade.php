@extends('layouts.app')

@section('content')
    <div class=" min-h-screen bg-gray-900 text-white">

        <div class=" w-2/3 mx-auto">
            <div class="flex justify-between items-center py-3">
                <h2 class="uppercase text-2xl text-purple-700 py-3 font-black">Authors</h2>
                <a href="{{ route('authors.create') }}" class="bg-orange-700 px-4 py-2 rounded">Add Author</a>
            </div>

            @if ($authors->count())
                <div class="mt-3">
                    @foreach ($authors as $index => $author)

                    <div class="flex justify-between items-center mt-3">
                        <div class="text-xl">{{ $author->name }} <span class="text-gray-300 text-sm">({{ $author->dob }})</span></div>

                        <div>
                            <button class="px-4 py-2 rounded-full text-sm w-20 bg-blue-400 focus:outline-none focus:shadow-outline">Edit</button>
                            <button class="px-4 py-2 rounded-full text-sm w-20 bg-red-400 focus:outline-none focus:shadow-outline ml-4">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div>
                    <p class=" text-orange-500">No Author Added Yet</p>
                </div>
            @endif

        </div>
    </div>
@endsection