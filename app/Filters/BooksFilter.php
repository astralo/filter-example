<?php


namespace App\Filters;


class BooksFilter extends Filter
{
    protected $filters = [
        'title',
        'description',
        'author',
        'rating_from',
        'rating_to',
        'published_year',
        'price_from',
        'price_to',
    ];

    /**
     * Filters books by title
     *
     * @param string $title
     */
    protected function title(string $title): void
    {
        $this->builder->where('title', 'like', "%{$title}%");
    }

    /**
     * Filters books by description
     *
     * @param string $description
     */
    protected function description(string $description): void
    {
        $this->builder->where('description', 'like', "%{$description}%");
    }

    /**
     * Filters books by author
     *
     * @param int $authorId
     */
    protected function author(int $authorId): void
    {
        $this->builder->where('author_id', $authorId);
    }

    /**
     * Filters books by rating smallest value
     *
     * @param int $rating
     */
    protected function rating_from(int $rating): void
    {
        $this->builder->where('rating', '>=', $rating);
    }

    /**
     * Filters books by rating biggest value
     *
     * @param int $rating
     */
    protected function rating_to(int $rating): void
    {
        $this->builder->where('rating', '<=', $rating);
    }

    /**
     * Filters books by publish date
     *
     * @param int $year
     */
    protected function published_year(int $year): void
    {
        $this->builder->where('published_year', $year);
    }

    /**
     * Filters books by price smallest value
     *
     * @param int $price
     */
    protected function price_from(int $price): void
    {
        $this->builder->where('price', '>=', $price);
    }

    /**
     * Filters books by price biggest value
     *
     * @param int $price
     */
    protected function price_to(int $price): void
    {
        $this->builder->where('price', '<=', $price);
    }
}
