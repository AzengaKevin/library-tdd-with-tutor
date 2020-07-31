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

        $this->post('/authors', $this->data());

        $authors = \App\Author::all();

        $this->assertCount(1, $authors);

        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
 
        $this->assertEquals('1997/06/10', $authors->first()->dob->format('Y/m/d'));
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->post('/authors', array_merge($this->data(), ['name' => '']))
            ->assertSessionHasErrors('name');

    }

    /** @test */
    public function dob_is_required()
    {
        $this->post('/authors', array_merge($this->data(), ['dob' => '']))
            ->assertSessionHasErrors('dob');
    }


    private function data()
    {
        return [
            'name' => 'JK Rowling',
            'dob' => '06/10/1997'
        ];
    }
}
