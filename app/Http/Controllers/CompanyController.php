<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller {
    public function index(Request $request, Company $companyService) {
        $paginate = $companyService->index($request->query);
        if ($paginate) {
            return response($paginate, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function store(CompanyStoreRequest $request, Company $companyService) {
        if ($companyService->store($request->validated(), $request->user('manager')->id)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function create() {
    }

    public function show($id) {
    }

    public function edit($id) {
    }

    public function update(CompanyUpdateRequest $request, $id, Company $companyService) {
        if ($companyService->update($request->validated(), $id)) {
            return response('Успешно изменено', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function destroy($id, Company $companyService) {
        if ($companyService->destroy($id)) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }
}