<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\InputBag;

class Company {
    public function index(InputBag $query) {
        $companies = \App\Models\Company::query();

        if ($query->get('name')) {
            $companies->where('name', 'like', '%' . $query->get('name') . '%');
        }
        if ($query->get('group')) {
            $companies->where('group', 'like', '%' . $query->get('group') . '%');
        }

        return $companies->orderByDesc('id')->paginate(10);
    }

    public function store($parameters, $by): bool {
        $createdModel = new \App\Models\Company($parameters);
        $createdModel->manager_id = $by;

        return $createdModel->save();
    }

    public function update($parameters): bool {
        return \App\Models\Company::update($parameters);
    }

    public function destroy($id): ?bool {
        return \App\Models\Company::find($id)->delete();
    }

    public function restore($id): bool {
        return \App\Models\Company::find($id)->restore();
    }
}