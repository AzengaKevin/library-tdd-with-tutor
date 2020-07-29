<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use Tests\TestCase;
use App\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_book_can_be_checked_out()
    {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();

        $book->checkout($user);

        $reservations = Reservation::all();

        $this->assertCount(1, $reservations);

        $this->assertEquals($user->id, $reservations->first()->user_id);

        $this->assertEquals($book->id, $reservations->first()->book_id);

        $this->assertEquals(now(), $reservations->first()->checked_out_at);

    }
    
    /** @test */
    public function a_book_can_be_returned()
    {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();

        $book->checkout($user);


        $book->checkin($user);

        $reservations = Reservation::all();

        $this->assertCount(1, $reservations);

        $this->assertEquals($user->id, $reservations->first()->user_id);

        $this->assertEquals($book->id, $reservations->first()->book_id);


        $this->assertNotNull($reservations->first()->checked_in_at);

        $this->assertEquals(now(), $reservations->first()->checked_in_at);
    }
    
    /** @test */
    public function if_a_book_is_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();

        $book->checkin($usser);

    }

    /** @test */
    public function a_user_can_checkout_a_book_twice()
    {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();

        $book->checkout($user);

        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());

        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $this->assertNull(Reservation::find(2)->checked_in_at);

        $book->checkin($user);

        $this->assertNotNull(Reservation::find(2)->checked_in_at);

        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);


    }
}
