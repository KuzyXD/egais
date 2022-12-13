<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fio' => 'bail|required|string',
            'password' => 'bail|required|string',
            'email' => 'bail|required|email',
            'note' => 'bail|nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
