<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{

    //Refreshes the in memory database for every single test
    use RefreshDatabase;
   
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        //Without exception handling
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $this->assertCount(1, \App\Book::all());

        $book = \App\Book::first();

        $response->assertRedirect($book->path());

        
    }

    /** @test */
    public function a_title_is_required()
    {

        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function an_author_is_required()
    {
        
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');

    }

    /** @test */
    public function a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();
        
        $this->post('/books', $this->data());

        $book = \App\Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title', $book->fresh()->title);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        
        $this->post('/books', $this->data());

        $book = \App\Book::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, \App\Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->post('/books', $this->data());

        $book = \App\Book::first();
        
        $authors = \App\Author::all();

        $this->assertCount(1, $authors);

        $this->assertEquals($book->author_id, $authors->first()->id);

    }

    private function data()
    {
        return [
            'title' => 'Harry Potter',
            'author_id' => 'J. K. Rowling'
        ];
    }
    
}
