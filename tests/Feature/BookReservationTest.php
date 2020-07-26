<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    //Refreshes the in memory database for every single test
    use RefreshDatabase;
   
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        //Without exception handling
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Coder\'s Tape Mutitenancy',
            'author' => 'Victor',
        ]);

        $response->assertOk();

        $this->assertCount(1, \App\Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function an_author_is_required()
    {
        
        $response = $this->post('/books', [
            'title' => 'Harry Potter',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');

    }

    /** @test */
    public function a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();
        
        $this->post('/books', [
            'title' => 'Harry Potter',
            'author' => 'JK Rowling',
        ]);



        $response = $this->patch('/books/' . \App\Book::first()->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $response->assertOk();

        $this->assertEquals('New Title', \App\Book::first()->title);

        $this->assertEquals('New Author', \App\Book::first()->author);
    }

    
}
