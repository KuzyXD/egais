<?php

namespace App\Services\RemoteGeneration;

use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\InputBag;

class RgCompany
{
    public function index(InputBag $query)
    {
        $rg_companies = \App\Models\RemoteGeneration\RgCompany::query();
        $currentPage = $query->get('page');

        $rg_companies->join('rg_managers', 'rg_companies.manager_id', '=', 'rg_managers.id')->latest()
            ->select([
                'rg_companies.id',
                'rg_companies.name',
                'rg_companies.group',
                'rg_managers.fio',
                'rg_companies.created_at',
                'rg_companies.updated_at',
                'rg_companies.deleted_at'
            ]);

        if ($query->get('sort')) {
            $sortby = explode(';', $query->get('sort'));
            foreach ($sortby as $sortbyraw) {
                $sorts = explode(',', $sortbyraw);
                $rg_companies->orderBy($sorts[0], $sorts[1]);
            }
        }

        if ($query->get('search')) {
            $rg_companies->orWhere('rg_companies.group', 'like', '%' . $query->get('search') . '%');
            $rg_companies->orWhere('rg_companies.name', 'like', '%' . $query->get('search') . '%');
            $rg_companies->orWhere('rg_managers.fio', 'like', '%' . $query->get('search') . '%');
            $rg_companies->orWhere('rg_companies.id', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false') === 'true') {
            $rg_companies->withTrashed();
        }
        if ($query->get('owned', false) === 'true') {
            $rg_companies->where('rg_companies.manager_id', '=', auth()->id());
        }

        return $rg_companies->paginate(6, ['*'], 'page', $currentPage);
    }

    public function store($parameters, $by): bool
    {
        $createdModel = new \App\Models\RemoteGeneration\RgCompany($parameters);
        $createdModel->manager_id = $by;

        return $createdModel->save();
    }

    public function update($parameters, $id): bool
    {
        return \App\Models\RemoteGeneration\RgCompany::find($id)->update($parameters);
    }

    public function destroy($id): ?bool
    {
        $company = \App\Models\RemoteGeneration\RgCompany::withTrashed()->find($id);

        if ($company->trashed()) {
            return $company->restore();
        }
        return $company->delete();
    }

    public function restore($id): bool
    {
        return \App\Models\RemoteGeneration\RgCompany::find($id)->restore();
    }

    public function indexCompanyByClientGroup($group): array
    {
        $array = \App\Models\RemoteGeneration\RgCompany::select('name')->whereGroup($group)->get()->toArray();
        return Arr::flatten($array);
    }
}
