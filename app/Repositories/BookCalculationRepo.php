<?php

namespace App\Repositories;

use App\Models\BookCalculation;

class BookCalculationRepo extends BaseRepo
{
    public function __construct(BookCalculation $model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model->with('book')->orderBy('num_of_read_pages', 'DESC')->take(5)->get();
    }

    public function findByBookId(int $book_id): ?BookCalculation
    {
        return $this->model->where('book_id', $book_id)->first();
    }
}
