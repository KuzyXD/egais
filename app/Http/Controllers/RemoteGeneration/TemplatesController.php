<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplatesStoreRequest;
use App\Http\Requests\TemplatesUpdateRequest;
use App\Http\Resources\RemoteGeneration\RgApplicationsTemplateResource;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Services\RemoteGeneration\RgTemplates;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function index(Request $request, $id, RgTemplates $templates)
    {
        $paginate = $templates->index($request->query, $id);
        if ($paginate) {
            return $paginate->response();
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function store(TemplatesStoreRequest $request, $id, RgTemplates $templates)
    {
        if ($templates->store($request->validated(), $request->user('rg-manager')->id, intval($id))) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function show($template_id)
    {
        return new RgApplicationsTemplateResource(RgApplicationsTemplate::find($template_id));
    }

    public function update(TemplatesUpdateRequest $request, $template_id, RgTemplates $templates)
    {
        if ($templates->update($request->validated(), $template_id)) {
            return response('Успешно изменено', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }

    public function destroy($template_id, RgTemplates $templates)
    {
        if ($templates->destroy($template_id)) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }
}
