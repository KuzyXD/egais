<?php

namespace App\Services\RemoteGeneration;

use App\Http\Resources\RemoteGeneration\RgApplicationsTemplateIndexResource;
use App\Http\Resources\RemoteGeneration\RgClientResource;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgClient as ModelsClient;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\InputBag;

class RgClient
{
    public function index(InputBag $query)
    {
        $rg_clients = ModelsClient::query();
        $currentPage = $query->get('page');

        if ($query->get('sort')) {
            $sortby = explode(';', $query->get('sort'));
            foreach ($sortby as $sortbyraw) {
                $sorts = explode(',', $sortbyraw);
                $rg_clients->orderBy($sorts[0], $sorts[1]);
            }
        }

        if ($query->get('search')) {
            $rg_clients->orWhere('rg_clients.fio', 'like', '%' . $query->get('search') . '%');
            $rg_clients->orWhere('rg_clients.certificate_serial_number', 'like', '%' . $query->get('search') . '%');
            $rg_clients->orWhere('rg_clients.note', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false') === 'true') {
            $rg_clients->withTrashed();
        }

        return RgClientResource::collection($rg_clients->paginate(6, ['*'], 'page', $currentPage));
    }

    public function create($parameters): ModelsClient
    {
        $parameters['password'] = Hash::make($parameters['password']);
        $parameters['certificate_expire_to_date'] = \Carbon\Carbon::parse($parameters['certificate_expire_to_date']);

        return ModelsClient::create($parameters);
    }

    public function update($parameters, \App\Models\RemoteGeneration\RgClient $rgClient): bool
    {
        $parameters['certificate_expire_to_date'] = \Carbon\Carbon::parse($parameters['certificate_expire_to_date']);
        return $rgClient->update($parameters);
    }

    public function destroy(\App\Models\RemoteGeneration\RgClient $rgClient): ?bool
    {
        if ($rgClient->trashed()) {
            return $rgClient->restore();
        }
        return $rgClient->delete();
    }
}
