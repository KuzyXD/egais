<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest {
    public function rules(): array {
        return [
                'name' => 'required|bail|string|unique:App\Models\Company,name',
                'group' => 'required|bail|string'
        ];
    }

    public function authorize(): bool {
        return true;
    }
}