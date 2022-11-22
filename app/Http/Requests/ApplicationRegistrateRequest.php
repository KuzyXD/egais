<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRegistrateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'templateId' => 'required|numeric',
            'login' => 'required|string',
            'pass' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
