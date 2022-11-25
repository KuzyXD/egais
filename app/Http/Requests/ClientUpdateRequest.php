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
            'certificate_serial_number' => 'bail|nullable|string',
            'certificate_expire_to_date' => 'bail|nullable|string|min:10|max:10',
            'note' => 'bail|nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
