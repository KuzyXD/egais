<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgCompany;
use Symfony\Component\HttpFoundation\InputBag;

class Company
{
    public function index(InputBag $query)
    {
        $rg_companies = RgCompany::query();
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

        return $rg_companies->orderByDesc('rg_companies.id')->paginate(6, ['*'], 'page', $currentPage);
    }

    public function store($parameters, $by): bool
    {
        $createdModel = new RgCompany($parameters);
        $createdModel->manager_id = $by;

        return $createdModel->save();
    }

    public function update($parameters, $id): bool
    {
        return RgCompany::find($id)->update($parameters);
    }

    public function destroy($id): ?bool
    {
        $company = RgCompany::withTrashed()->find($id);

        if ($company->trashed()) {
            return $company->restore();
        }
        return $company->delete();
    }

    public function restore($id): bool
    {
        return RgCompany::find($id)->restore();
    }
}
