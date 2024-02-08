<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterval extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|numeric|exists:books,id',
            'start_page' => 'required|numeric|min:0',
            'end_page' => 'sometimes|numeric|gt:start_page',
        ];
    }
}
