<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicecostRequest;
use App\Http\Requests\UpdateServicecostRequest;
use App\Http\Resources\Admin\ServicecostResource;
use App\Servicecost;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicecostApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicecost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicecostResource(Servicecost::with(['service', 'created_by'])->get());
    }

    public function store(StoreServicecostRequest $request)
    {
        $servicecost = Servicecost::create($request->all());

        return (new ServicecostResource($servicecost))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Servicecost $servicecost)
    {
        abort_if(Gate::denies('servicecost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicecostResource($servicecost->load(['service', 'created_by']));
    }

    public function update(UpdateServicecostRequest $request, Servicecost $servicecost)
    {
        $servicecost->update($request->all());

        return (new ServicecostResource($servicecost))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Servicecost $servicecost)
    {
        abort_if(Gate::denies('servicecost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicecost->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
