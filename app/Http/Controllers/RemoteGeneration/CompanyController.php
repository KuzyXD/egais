<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\RemoteGeneration\RgCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request, RgCompany $companyService)
    {
        $paginate = $companyService->index($request->query);
        if ($paginate) {
            return response($paginate, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function store(CompanyStoreRequest $request, RgCompany $companyService)
    {
        if ($companyService->store($request->validated(), $request->user('rg-manager')->id)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function update(CompanyUpdateRequest $request, $id, RgCompany $companyService)
    {
        if ($companyService->update($request->validated(), $id)) {
            return response('Успешно изменено', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function indexCompanyByClientGroup(Request $request, RgCompany $companyService)
    {
        $result = $companyService->indexCompanyByClientGroup($request->user('rg-client')->group);
        if ($result) {
            return response($result, 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function destroy($id, RgCompany $companyService)
    {
        if ($companyService->destroy($id)) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
