<?php

namespace App\Http\Requests;

use App\Enums\FileTypes;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequestFileRequest extends FormRequest
{
    public function rules(): array
    {
        $fileTypes = implode(',', FileTypes::toLabels());
        
        return [
            'file' => 'required|string',
            'type' => "required|string|in:$fileTypes"
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
