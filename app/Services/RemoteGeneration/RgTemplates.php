<?php

namespace App\Services\RemoteGeneration;

use App\Http\Resources\RemoteGeneration\RgApplicationsTemplateResource;
use App\Http\Resources\RemoteGeneration\RgApplicationsTemplateShowResource;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\InputBag;

class RgTemplates
{
    public function index(InputBag $query, $companyId)
    {
        $rg_applications_templates = RgApplicationsTemplate::query()->whereCreatedFor($companyId);
        $currentPage = $query->get('page');

        $rg_applications_templates->join('rg_managers', 'rg_applications_templates.created_by', '=', 'rg_managers.id')->latest()
            ->select([
                'rg_applications_templates.id',
                'rg_applications_templates.created_by',
                'rg_applications_templates.type',
                'rg_applications_templates.applicant_fio',
                'rg_managers.fio',
                'rg_applications_templates.head_fio',
                'rg_applications_templates.products',
                'rg_applications_templates.created_at',
                'rg_applications_templates.updated_at',
                'rg_applications_templates.deleted_at'
            ]);

        if ($query->get('sort')) {
            $sortby = explode(';', $query->get('sort'));
            foreach ($sortby as $sortbyraw) {
                $sorts = explode(',', $sortbyraw);
                $rg_applications_templates->orderBy($sorts[0], $sorts[1]);
            }
        }

        if ($query->get('search')) {
            $rg_applications_templates->orWhere('rg_applications_templates.applicant_fio', 'like', '%' . $query->get('search') . '%');
            $rg_applications_templates->orWhere('rg_applications_templates.head_fio', 'like', '%' . $query->get('search') . '%');
            $rg_applications_templates->orWhere('rg_applications_templates.products', 'like', '%' . $query->get('search') . '%');
            $rg_applications_templates->orWhere('rg_managers.fio', 'like', '%' . $query->get('search') . '%');
            $rg_applications_templates->orWhere('rg_applications_templates.id', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false') === 'true') {
            $rg_applications_templates->withTrashed();
        }
        if ($query->get('owned', false) === 'true') {
            $rg_applications_templates->where('rg_applications_templates.created_by', '=', auth()->id());
        }

        return RgApplicationsTemplateShowResource::collection($rg_applications_templates->paginate(6, ['*'], 'page', $currentPage));
    }

    public function store($parameters, $by, $companyId): bool
    {
        $createdModel = new RgApplicationsTemplate($parameters);
        $createdModel->created_by = $by;
        $createdModel->created_for = $companyId;
        $createdModel->applicant_fio = $this->getFioString($parameters['lastName'], $parameters['firstName'], $parameters['middleName']);
        $createdModel->head_fio = $this->getFioString($parameters['headLastName'], $parameters['headFirstName'], $parameters['headMiddleName']);

        return $createdModel->save();
    }

    public function getFioString($lastName, $firstName, $middleName): \Illuminate\Support\Stringable
    {
        return Str::of($lastName)
            ->append(' ' . $firstName)
            ->append(' ' . $middleName)
            ->rtrim();
    }

    public function update($parameters, $id): bool
    {
        return RgApplicationsTemplate::find($id)->update($parameters);
    }

    public function destroy($id): ?bool
    {
        $templateModel = RgApplicationsTemplate::withTrashed()->find($id);

        if ($templateModel->trashed()) {
            return $templateModel->restore();
        }
        return $templateModel->delete();
    }

    public function restore($id): bool
    {
        return \App\Models\RemoteGeneration\RgCompany::find($id)->restore();
    }
}
