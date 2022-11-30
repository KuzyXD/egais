<?php

namespace App\Services\RemoteGeneration;

use Illuminate\Support\Arr;

class RgClientGroup
{
    public function index(): array
    {
        $array = \App\Models\RemoteGeneration\RgCompany::select('group')->groupBy('group')->get()->toArray();
        return Arr::flatten($array);
    }

    public function show(\App\Models\RemoteGeneration\RgClient $rgClient): array
    {
        $array = $rgClient->select('group')->get()->toArray();
        return Arr::flatten($array);
    }

    public function update(\App\Models\RemoteGeneration\RgClient $rgClient, $newGroup): bool
    {
        return $rgClient->update(['group' => $newGroup]);
    }
}
