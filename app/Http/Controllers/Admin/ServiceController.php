<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Service;
use App\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_s = Service::all();

        return view('admin.service_s.index', compact('service_s'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.service_s.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $service_ = Service::create($request->all());

        return redirect()->route('admin.service-s.index');
    }

    public function edit(Service $service_)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_->load('created_by');

        return view('admin.service_s.edit', compact('service_'));
    }

    public function update(UpdateServiceRequest $request, Service $service_)
    {
        $service_->update($request->all());

        return redirect()->route('admin.service-s.index');
    }

    public function show(Service $service_)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_->load('created_by');

        return view('admin.service_s.show', compact('service_'));
    }

    public function destroy(Service $service_)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceRequest $request)
    {
        Service::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function servicefilter(Request $request)
    {
      if (!$request->site_id) {
        $html = '<option value="">'.trans('global.pleaseSelect').'</option>';
    } else {
        $html = '';
        $sites = Site::where('id', $request->site_id)->get()->load('services');
        foreach ($sites as $id => $site) {
          foreach ($site->services as $id => $service) {
            $html .= '<option value="'.$service->id.'">'.$service->name.'</option>';
          }
        }
      }
          return response()->json(['html' => $html]);
      }
}
