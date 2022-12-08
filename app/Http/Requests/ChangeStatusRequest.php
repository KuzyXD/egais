<?php

namespace App\Http\Requests;

use App\Enums\Statuses;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        $statuses = implode(',', Statuses::toLabels());

        return [
            'status' => "required|string|in:$statuses"
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
