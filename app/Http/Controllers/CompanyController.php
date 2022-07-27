<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Services\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller {
    public function index() {

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

    public function update(Request $request, $id) {
    }

    public function destroy($id) {
    }
}