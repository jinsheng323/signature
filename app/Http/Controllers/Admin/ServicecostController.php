<?php

namespace App\Http\Controllers\Admin;

use App\Servicecost;
use App\Service;
use App\Site;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicecostRequest;
use App\Http\Requests\StoreServicecostRequest;
use App\Http\Requests\UpdateServicecostRequest;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicecostController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicecost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicecosts = Servicecost::all();
        return view('admin.servicecosts.index', compact('servicecosts'));
    }

    public function create()
    {
        abort_if(Gate::denies('servicecost_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sites = Site::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servicecosts.create', compact('services'));
    }

    public function store(StoreServicecostRequest $request)
    {
        $servicecost = Servicecost::create($request->all());

        return redirect()->route('admin.servicecosts.index');
    }

    public function edit(Servicecost $servicecost)
    {
        abort_if(Gate::denies('servicecost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sites = Site::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicecost->load('service', 'created_by');

        return view('admin.servicecosts.edit', compact('services','sites', 'servicecost'));
    }

    public function update(UpdateServicecostRequest $request, Servicecost $servicecost)
    {
        $servicecost->update($request->all());

        return redirect()->route('admin.servicecosts.index');
    }

    public function show(Servicecost $servicecost)
    {
        abort_if(Gate::denies('servicecost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicecost->load('service', 'created_by');

        return view('admin.servicecosts.show', compact('servicecost'));
    }

    public function destroy(Servicecost $servicecost)
    {
        abort_if(Gate::denies('servicecost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicecost->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicecostRequest $request)
    {
        Servicecost::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
