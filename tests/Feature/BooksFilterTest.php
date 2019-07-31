<?php

namespace Tests\Feature;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_filters_by_title(): void
    {
        $redBook = factory(Book::class)->create(['title' => 'red']);
        $greenBook = factory(Book::class)->create(['title' => 'green']);

        $this->assertCount(2, Book::all());

        $response = $this->json('get', route('books'), ['title' => 'red']);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(1, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$redBook]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_description(): void
    {
        $redBook = factory(Book::class)->create(['description' => 'this is a red description']);
        $greenBook = factory(Book::class)->create(['description' => 'this is a green description']);

        $this->assertCount(2, Book::all());

        $response = $this->json('get', route('books'), ['description' => 'red']);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(1, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$redBook]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_publish_date(): void
    {
        $bookFrom1990 = factory(Book::class)->create(['published_year' => 1990]);
        $bookFrom2008 = factory(Book::class)->create(['published_year' => 2008]);

        $this->assertCount(2, Book::all());

        $response = $this->json('get', route('books'), ['published_year' => '1990']);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(1, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$bookFrom1990]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_min_rating(): void
    {
        $book2 = factory(Book::class)->create(['rating' => 2]);
        $book5 = factory(Book::class)->create(['rating' => 5]);
        $book10 = factory(Book::class)->create(['rating' => 10]);

        $this->assertCount(3, Book::all());

        $response = $this->json('get', route('books'), ['rating_from' => 3]);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(2, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$book5, $book10]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_max_rating(): void
    {
        $book2 = factory(Book::class)->create(['rating' => 2]);
        $book5 = factory(Book::class)->create(['rating' => 5]);
        $book10 = factory(Book::class)->create(['rating' => 10]);

        $this->assertCount(3, Book::all());

        $response = $this->json('get', route('books'), ['rating_to' => 7]);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(2, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$book2, $book5]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_min_price(): void
    {
        $bookFor100 = factory(Book::class)->create(['price' => 100]);
        $bookFor300 = factory(Book::class)->create(['price' => 300]);
        $bookFor500 = factory(Book::class)->create(['price' => 500]);

        $this->assertCount(3, Book::all());

        $response = $this->json('get', route('books'), ['price_from' => 200]);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(2, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$bookFor300, $bookFor500]))->response()->getContent(), true),
            $result
        );
    }

    /** @test */
    public function it_filters_by_max_price(): void
    {
        $bookFor100 = factory(Book::class)->create(['price' => 100]);
        $bookFor300 = factory(Book::class)->create(['price' => 300]);
        $bookFor500 = factory(Book::class)->create(['price' => 500]);

        $this->assertCount(3, Book::all());

        $response = $this->json('get', route('books'), ['price_to' => 400]);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(2, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$bookFor100, $bookFor300]))->response()->getContent(), true),
            $result
        );
    }


    /** @test */
    public function it_filters_by_author(): void
    {
        $john = factory(User::class)->create();
        $sam = factory(User::class)->create();

        $johnsBook = factory(Book::class)->create(['author_id' => $john->id]);
        $samsBook = factory(Book::class)->create(['author_id' => $sam->id]);

        $this->assertCount(2, Book::all());

        $response = $this->json('get', route('books'), ['author' => $john->id]);

        $response->assertOk();

        $result = $response->json();

        $this->assertCount(1, $result['data']);
        $this->assertEquals(
            json_decode(BookResource::collection(collect([$johnsBook]))->response()->getContent(), true),
            $result
        );
    }
}
