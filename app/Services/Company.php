<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\InputBag;

class Company {
    public function index(InputBag $query) {
        $companies = \App\Models\Company::query();
        $currentPage = $query->get('page');

        if ($query->get('name')) {
            $companies->where('name', 'like', '%' . $query->get('name') . '%');
        }
        if ($query->get('group')) {
            $companies->where('group', 'like', '%' . $query->get('group') . '%');
        }
        if ($query->get('deleted'==='true')) {
            $companies->withTrashed();
        }

        return $companies->orderByDesc('id')->paginate(10, ['*'], 'page', $currentPage);
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
        $company = \App\Models\Company::find($id);

        if ($company->trashed()) {
            return $company->restore();
        }
        return $company->delete();
    }

    public function restore($id): bool {
        return \App\Models\Company::find($id)->restore();
    }
}