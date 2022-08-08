<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\InputBag;

class Company {
    public function index(InputBag $query) {
        $companies = \App\Models\Company::query();
        $currentPage = $query->get('page');

        $companies->join('managers', 'companies.manager_id', '=', 'managers.id')->latest()
                ->select([
                        'companies.id',
                        'companies.name',
                        'companies.group',
                        'managers.fio',
                        'companies.created_at',
                        'companies.updated_at',
                        'companies.deleted_at'
                ]);


        if ($query->get('search')) {
            $companies->orWhere('companies.group', 'like', '%' . $query->get('search') . '%');
            $companies->orWhere('companies.name', 'like', '%' . $query->get('search') . '%');
            $companies->orWhere('managers.fio', 'like', '%' . $query->get('search') . '%');
            $companies->orWhere('companies.id', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false')==='true') {
            $companies->withTrashed();
        }
        if ($query->get('owned', false)==='true') {
            $companies->where('companies.manager_id', '=', auth()->id());
        }

        return $companies->orderByDesc('companies.id')->paginate(6, ['*'], 'page', $currentPage);
    }

    public function store($parameters, $by): bool {
        $createdModel = new \App\Models\Company($parameters);
        $createdModel->manager_id = $by;

        return $createdModel->save();
    }

    public function update($parameters, $id): bool {
        return \App\Models\Company::find($id)->update($parameters);
    }

    public function destroy($id): ?bool {
        $company = \App\Models\Company::withTrashed()->find($id);

        if ($company->trashed()) {
            return $company->restore();
        }
        return $company->delete();
    }

    public function restore($id): bool {
        return \App\Models\Company::find($id)->restore();
    }
}