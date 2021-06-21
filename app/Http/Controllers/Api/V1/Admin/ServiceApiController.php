<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\Admin\ServiceResource;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceResource(Service::with(['created_by'])->get());
    }

    public function store(StoreServiceRequest $request)
    {
        $service_ = Service::create($request->all());

        return (new ServiceResource($service_))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Service $service_)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceResource($service_->load(['created_by']));
    }

    public function update(UpdateServiceRequest $request, Service $service_)
    {
        $service_->update($request->all());

        return (new ServiceResource($service_))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Services $service_)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
