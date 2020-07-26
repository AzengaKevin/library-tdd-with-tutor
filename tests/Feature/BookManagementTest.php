<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
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

        $this->assertCount(1, \App\Book::all());

        $book = \App\Book::first();

        $response->assertRedirect($book->path());

        
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

        $book = \App\Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', $book->fresh()->title);

        $this->assertEquals('New Author', $book->fresh()->author);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        
        $this->post('/books', [
            'title' => 'Harry Potter',
            'author' => 'JK Rowling',
        ]);

        $book = \App\Book::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, \App\Book::all());

        $response->assertRedirect('/books');
    }
    
}
