<?php

namespace App\Http\Resources;

use App\Enums\FileTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileFromAC extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $type = FileTypes::from($this['type']);

        return [
            'name' => $this['name'],
            'type' => $type->label,
            'file' => base64_decode($this['contentBase64'])
        ];
    }
}
