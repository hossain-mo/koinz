<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterval;
use App\Http\Resources\BookCalculation;
use App\Services\BookCalculationService;
use Illuminate\Routing\Controller as BaseController;

class BookCalculationController extends BaseController
{
    protected $bookCalculationService;

    public function __construct(BookCalculationService $bookCalculationService)
    {
        $this->bookCalculationService = $bookCalculationService;
    }

    public function index()
    {
        return response()->json(BookCalculation::collection($this->bookCalculationService->get()));
    }

    public function store(StoreInterval $request)
    {
        return response()->json($this->bookCalculationService->create($request->validated()));
    }
}
