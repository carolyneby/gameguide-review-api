<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Any authenticated user can add a game in this demo project.
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'min:1970', 'max:' . (date('Y') + 1)],
        ];
    }
}
