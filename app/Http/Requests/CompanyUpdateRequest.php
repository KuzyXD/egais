<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest {
    public function rules(): array {
        return [
                'name' => 'bail|string|unique:App\Models\Company,name',
                'group' => 'bail|string',
                'manager_id' => 'bail|numeric'
        ];
    }

    public function authorize(): bool {
        return true;
    }
}