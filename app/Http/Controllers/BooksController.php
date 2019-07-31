<?php

namespace App\Http\Controllers;

use App\Filters\BooksFilter;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BooksController extends Controller
{
    /**
     * Return filtered list of books
     *
     * @param BooksFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(BooksFilter $filter): AnonymousResourceCollection
    {
        $books = Book::filter($filter)->with(['author'])->get();

        return BookResource::collection($books);
    }
}
