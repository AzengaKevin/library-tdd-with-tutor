<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use App\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTransactionTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out_by_an_authenticated_user()
    {

        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create());

        $this->post('/checkout/' . $book->id);

            $this->assertCount(1, Reservation::all());
    
            $this->assertEquals($user->id, Reservation::first()->user_id);
    
            $this->assertEquals($book->id, Reservation::first()->book_id);
    
            $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

    /** @test */
    public function a_user_must_be_authenticated_to_checkout_a_book()
    {

        $book = factory(Book::class)->create();

        $this->post('/checkout/' . $book->id)
            ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    /** @test */
    public function only_real_books_can_be_checked_out()
    {

        $this->actingAs($user = factory(User::class)->create());

        $this->post('/checkout/22')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());

    }


    /** @test */
    public function a_book_can_be_checked_in_by_an_authenticated_user()
    {

        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create());

        $this->post('/checkout/' . $book->id);

        $this->patch('/checkin/' . $book->id);


        $this->assertCount(1, Reservation::all());

        $this->assertEquals($user->id, Reservation::first()->user_id);

        $this->assertEquals($book->id, Reservation::first()->book_id);

        $this->assertEquals(now(), Reservation::first()->checked_out_at);

        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }

    /** @test */
    public function a_user_must_be_authenticated_to_checkin_a_book()
    {

        $book = factory(Book::class)->create();

        $this->actingAs(factory(User::class)->create());

        $this->post('/checkout/' . $book->id);
        
        Auth::logout();
        
        $this->patch('/checkin/' . $book->id)
            ->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());

        $this->assertNull(Reservation::first()->checked_in_at);

    }

    /** @test */
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {
        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create());

        $this->patch('/checkin/' . $book->id)
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());

    }

}
