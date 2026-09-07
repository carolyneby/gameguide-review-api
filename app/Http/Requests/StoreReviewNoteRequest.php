<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guide_id' => ['required', 'exists:guides,id'],
            'body' => ['required', 'string', 'min:3'],
        ];
    }
}
