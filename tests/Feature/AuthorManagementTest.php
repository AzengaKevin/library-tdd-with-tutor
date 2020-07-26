<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_author_can_be_created()
    {

        $this->withoutExceptionHandling();

        $this->post('/authors', [
            'name' => 'JK Rowling',
            'dob' => '06/10/1997'
        ]);

        $authors = \App\Author::all();

        $this->assertCount(1, $authors);

        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
 
        $this->assertEquals('1997/06/10', $authors->first()->dob->format('Y/m/d'));
    }
}
