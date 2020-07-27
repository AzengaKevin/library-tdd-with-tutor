<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function a_date_of_birth_is_optional()
    {
        Author::firstOrCreate([
            'name' => 'JK Rowling'
        ]);

        $this->assertCount(1, Author::all());
    }
}
