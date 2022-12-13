<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fio' => 'bail|nullable|string',
            'password' => 'bail|nullable|string',
            'email' => 'bail|nullable|email',
            'note' => 'bail|nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
