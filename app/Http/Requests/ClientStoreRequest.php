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
            'certificate_serial_number' => 'bail|required|string',
            'certificate_expire_to_date' => 'bail|required|string|min:10|max:10',
            'note' => 'bail|nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
