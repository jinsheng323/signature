<?php

namespace App\Http\Controllers\Admin;

use App\Site;
use App\Contract;
use App\Service;
use App\Servicecost;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySiteRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Log;

class SiteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sites = Site::all();

        return view('admin.sites.index', compact('sites'));
    }

    public function create()
    {
      abort_if(Gate::denies('site_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contracts = Contract::where('status_id', '1')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id');
        return view('admin.sites.create', compact('contracts', 'services','servicecosts', 'services1'));
    }

    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->all());
        $site->services()->sync($request->input('services', []));
        $this->cost($site);
        return redirect()->route('admin.sites.index');
    }

    public function cost(Site $site)
    {
      $db = mysqli_connect("localhost","signature","Fast2019!","signature");
      if (!$db) {
          die("Connection failed: " . mysqli_connect_error());
      }
      foreach ($site->services as $id => $service) {
          $sql = "INSERT INTO `servicecosts` (`id`, `site_id`, `service_id`, `cost`, `created_at`, `updated_at`, `deleted_at`) VALUES (Null, '$site->id', '$service->id', '0', CURRENT_TIME(), CURRENT_TIME(), NULL)";
          if (mysqli_query($db, $sql)) {
              error_log( "Record updated successfully");
          } else {
              error_log( "Error updating record: " . mysqli_error($db));
          }
      }
      mysqli_close($db);

        return ;
    }

    public function edit(Site $site)
    {
        abort_if(Gate::denies('site_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contracts = Contract::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id');
        $site->load('contract', 'created_by');
        $site->load('services');
        return view('admin.sites.edit', compact('contracts','services', 'site'));
    }

    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->all());
        $site->services()->sync($request->input('services', []));
        $services = $request->services;
        $servicecosts = Servicecost::where('site_id', $site->id)->get();
        foreach ($services as $key => $service) {
          $a = 0;
          foreach ($servicecosts as $key => $servicecost) {
            if($servicecost->service_id == $service)
            {
              $a = 1;
              break;
            }
          }
          if($a == 0)
          {
            $db = mysqli_connect("localhost","signature","Fast2019!","signature");
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO `servicecosts` (`id`, `site_id`, `service_id`, `cost`, `created_at`, `updated_at`, `deleted_at`) VALUES (Null, '$site->id', '$service', '0', CURRENT_TIME(), CURRENT_TIME(), NULL)";
            if (mysqli_query($db, $sql)) {
                error_log( "Record updated successfully");
            } else {
                error_log( "Error updating record: " . mysqli_error($db));
            }
            mysqli_close($db);
          }
        }

        foreach ($servicecosts as $key => $servicecost) {
          $a = 0;
          foreach ($services as $key => $service) {
            if($servicecost->service_id == $service)
            {
              $a = 1;
              break;
            }
          }
          if($a == 0)
          {
            $db = mysqli_connect("localhost","signature","Fast2019!","signature");
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            foreach ($site->services as $id => $service) {
                $sql = "DELETE FROM `servicecosts` WHERE `servicecosts`.`id` = $servicecost->id";
                if (mysqli_query($db, $sql)) {
                    error_log( "Record updated successfully");
                } else {
                    error_log( "Error updating record: " . mysqli_error($db));
                }
            }
            mysqli_close($db);
          }
        }

        return redirect()->route('admin.sites.index');
    }

    public function show(Site $site)
    {
        abort_if(Gate::denies('site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->load('contract', 'created_by');
        $site->load('services');

        return view('admin.sites.show', compact('site', 'services'));
    }

    public function destroy(Site $site)
    {
        abort_if(Gate::denies('site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->delete();
        $db = mysqli_connect("localhost","signature","Fast2019!","signature");
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }
        foreach ($site->services as $id => $service) {
            $sql = "DELETE FROM `servicecosts` WHERE `servicecosts`.`site_id` = $site->id";
            if (mysqli_query($db, $sql)) {
                error_log( "Record updated successfully");
            } else {
                error_log( "Error updating record: " . mysqli_error($db));
            }
        }
        mysqli_close($db);

        return back();
    }

    public function massDestroy(MassDestroySiteRequest $request)
    {
        Site::whereIn('id', request('ids'))->delete();
        Servicecost::whereIn('site_id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function sitefilter(Request $request)
    {
      if (!$request->contract_id) {
          $html = '<option value="">'.trans('global.pleaseSelect').'</option>';
      } else {
          $html = '';
          $sites = Site::where('contract_id', $request->contract_id)->get();
          $html .= '<option value=""></option>';
          foreach ($sites as $site) {
              $html .= '<option value="'.$site->id.'">'.$site->name.'</option>';
          }
      }
      return response()->json(['html' => $html]);
    }
}
