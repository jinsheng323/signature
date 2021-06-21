<?php

namespace App\Http\Controllers\Job;

use App\Job;
use App\Contract;
use App\Service;
use App\Site;
use App\Servicecost;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyJobRequest;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use PDF;
use App\Inv;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('job_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $jobs = Job::all();
        $contracts = Contract::where('status_id', '1')->pluck('name', 'id');
        $sites = Site::all()->pluck('name', 'id');
        $status_ = array('Complete', 'Pending', 'Billed','Payed');
        return view('jobs.index', compact('jobs','contracts', 'sites','status_'));
    }

    public function create()
    {
    //  abort_if(Gate::denies('job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contracts = Contract::where('status_id', '1')->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$sites = Site::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('jobs.create', compact('contracts'));
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->all());
        $job->services()->sync($request->input('services', []));
      //  $service = Job::create($request->all());
      //  $site = Job::create($request->all());
        return redirect()->route('jobs.index');
    }


    public function edit(Job $job)
    {
      //  abort_if(Gate::denies('job_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //    $sites = Contract::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    //    $services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $job->load('contract', 'created_by');
        $job->load('services');
        return view('jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->update($request->all());
        $job->services()->sync($request->input('services', []));

        return redirect()->route('jobs.index');
    }

    public function show(Job $job)
    {
      //  abort_if(Gate::denies('job_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      $contracts = Contract::where('status_id', '1')->pluck('name', 'id');
      $sites = Site::where('contract_id', $job->contract_id)->pluck('name', 'id');
      //$sites = Site::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
      //$services = Service::all()->pluck('name', 'id');
      $job->load('contract', 'created_by');
      $job->load('site', 'created_by');
      $job->load('services');
      $site = $job->site->load('services');
      $services = $site->services->pluck('name', 'id');
      return view('jobs.show', compact('contracts','services','sites', 'job'));
    }

    public function destroy(Job $job)
    {
      //  abort_if(Gate::denies('job_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job->delete();

        return back();
    }


    public function massDestroy(MassDestroyJobRequest $request)
    {
        Job::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function savesign(Request $request)
    {
      $job = $_POST['job'];
      $str_job = explode("_", $job);
      $job = new Job;
      $job->name = $str_job[0];
      $job->contract_id = $str_job[1];
      $job->site_id = $str_job[2];
      $job->status = "Complete";
      $job->save();
      $job->signpath = "/IMAGE/".$job->id.'.png';
      $job->save();
      $mytime = new Carbon();
      $mytime->setTimezone('America/New_York')->toDateTimeString();

      $db = mysqli_connect("localhost","signature","Fast2019!","signature");
      if (!$db) {
          die("Connection failed: " . mysqli_connect_error());
      }
      $ids = explode(",",$str_job[3]);
      foreach ($ids as $i) {
          $job_id = $job->id;
          $sql = "INSERT INTO `job_service` (`job_id`, `service_id`) VALUES ('$job_id', '$i')";
          if (mysqli_query($db, $sql)) {
              error_log( "Record updated successfully");
          } else {
              error_log( "Error updating record: " . mysqli_error($db));
          }

          $sql = "UPDATE `jobs` SET `sign_create` = '$mytime' WHERE `jobs`.`id` = '$job_id'";
          if (mysqli_query($db, $sql)) {
              error_log( "Record updated successfully");
          } else {
              error_log( "Error updating record: " . mysqli_error($db));
          }
      }
      mysqli_close($db);
      $encoded_image = $str_job[5];
      $decoded_image = base64_decode($encoded_image);
      $r = file_put_contents(base_path()."/IMAGE/".$job->id.".png", $decoded_image);
      return $r;
    }

    public function resavesign(Request $request)
    {
      $job = $_POST['job'];
      $str_job = explode(",", $job);
      $mytime = new Carbon();
      $mytime->setTimezone('America/New_York')->toDateTimeString();
      $var_path = "/IMAGE/".$str_job[0].'.png';
      $conn = mysqli_connect("localhost","signature","Fast2019!","signature");
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      $sql = "UPDATE jobs SET signpath = '$var_path', sign_create = '$mytime', status = 'Complete' WHERE id = $str_job[0]";
      if (mysqli_query($conn, $sql)) {
          error_log( "Record updated successfully");
      } else {
          error_log( "Error updating record: " . mysqli_error($conn));
      }

      mysqli_close($conn);

      $encoded_image = $str_job[1];
      $decoded_image = base64_decode($encoded_image);
      $r = file_put_contents(base_path()."/IMAGE/".$str_job[0].'.png', $decoded_image);
      return $r;
    }



    public function filter(Request $request)
    {
      /*$cat = $_POST['cat'];
      $str_cat = explode(",", $cat);*/
      $m = [];
      if($_POST['contract_id'])
      {
        $m['contract_id'] = $_POST['contract_id'];
      }
      if($_POST['site_id'])
      {
        $m += ['site_id' => $_POST['site_id']];
      }
      if($_POST['filter_status'])
      {
        $m += ['status' => $_POST['filter_status']];
      }
      //$m = ['contract_id' => $_POST['contract_id'], 'site_id' => $_POST['site_id'], 'status' => $_POST['status']];
      if(!$_POST['to_date'])
      {
        $jobs = Job::where($m)->whereDate('created_at','>=',$_POST['from_date'])->get();
      }else{
          $jobs = Job::where($m)->whereDate('created_at','>=',$_POST['from_date'])->whereDate('created_at','<=',$_POST['to_date'])->get();
      }

      $contracts = Contract::where('status_id', '1')->pluck('name', 'id');
      $sites = Site::all()->pluck('name', 'id');
      $status_ = array('Complete', 'Pending', 'Billed','Payed');
      return view('jobs.index', compact('jobs','contracts', 'sites','status_'));

    }

    public function generatebill($id)
   {

     //$ids = explode(",", $request['ids']);
     //$ids = $request['ids'];
     $html = '<!doctype html>
              <html lang="en">
              <head>
                  <meta charset="UTF-8">
                  <title>Sign Off</title>
                  <style type="text/css">
                      @page {
                          margin: 40px;
                      }
                      body {
                          margin: 40px;
                      }
                      * {
                          font-family: Verdana, Arial, sans-serif;
                      }
                      a {
                          color: #fff;
                          text-decoration: none;
                      }
                      table {
                          font-size: 15px;

                      }
                      tfoot tr td {
                          font-weight: bold;
                          font-size: x-small;
                      }
                      .pdf table {
                          margin: 10px;
                      }
                      .pdf h3 {
                          margin-left: 10px;
                      }
                      .pdfinformation {
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                          color: #000;
                      }
                      .pdf .logo {
                          margin: 5px;
                      }
                      .pdfinformation table {
                          padding: 20px;
                      }
                      .invoice table {
                          margin: 0px;
                      }
                      .invoice tfoot {
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice thead tr th{
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice tbody tr th{
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice thead tr td{
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice tbody tr td{
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice tfoot tr td{
                        border-left: 2px solid #c8ced3;
                        border-bottom: 2px solid #c8ced3;
                        border-right: 2px solid #c8ced3;
                        border-top: 2px solid #c8ced3;
                      }
                      .invoice h3 {
                          margin-left: 10px;
                          margin-right: 10px;
                      }
                      .information {
                          color: #000;
                      }
                      .information .logo {
                          margin: 5px;
                      }
                      .information table {
                          padding: 0px;
                      }
                      .rightaligned{
                          margin-right: 0px;
                          margin-left: auto;
                      }
                  </style>
              </head>';
        $jobs = Job::where('id', $id)->get();
        foreach($jobs as $job){
            $job->load('contract', 'created_by');
            $job->load('site', 'created_by');
            $job->load('services');
            $date = strtotime($job->sign_create);
            $myNewDate = Date('m-d-Y H:i', $date);
            $html .= '<body><div class="pdfinformation"><table width="100%"><tr><td align="left" style="width: 40%;"><h3>Signature Window Cleaning Services</h3><h3>378 Westbrook Hills Dr.</h3><h3>Syracuse, NY 13215</h3><br/></td><td align="right" style="width: 40%;"><pre>Date: '.$myNewDate.'</pre></td></tr></table></div><br/><div class="pdfinformation" ><table width="100%"><tr><td align="left" style="width: 50%;"><h3>Bill To : '.$job->contract->name.'</h3><h3>Store : '.$job->site->name.'</h3></td></tr></table></div><div class="pdf"><h3>Service:</h3><table width="100%"><thead>';
            foreach($job->services as $key => $service)
            {
              $html .= '<tr><td align="left">'.$service->name.'</td></tr>';
            }
            $path = getcwd().'/IMAGE/'.$job->id.'.png';
            $html .= '</thead></table></div><div class="pdf" style="position: absolute; bottom: 0;"><table width="100%"><tr><td>Store Signature  </td><td> <img src='.$path.' alt="Logo" width="350" height="150" class="logo"/></td></tr></table></div></body>';

          $servicecosts = Servicecost::where('site_id', $job->site_id)->get();
          $job->load('contract', 'created_by');
          $job->load('site', 'created_by');
          $job->load('services');
          $html .= '<body><table width="100%" style="table-layout:fixed"><tr>
          <td  align="left"><h4>Signature Window Cleaning Services</h4>
          <b>378 Westbrook Hills Dr.</b><br/><br/><b>Syracuse, NY 13215</b></td>
          <td align="right"><h4>Invoice</h4><br/>
          <table class="invoice" cellspacing="0" cellpadding="7" style="margin-right:0px;margin-left:auto;"><tr><th>Date</th><th>Invoice#</th></tr><tr><td>'.$myNewDate.'</td><td align="center">'.$job->inv_num.'</td></tr></table></td></tr></table><br/>
          <br/><table style="table-layout:fixed" width="100%"><tr><td><div class="invoice"><table width="100%" cellspacing="0" cellpadding="7" align="left"><thead><tr>
          <td ><h4>Bill To :</h4></td></tr></thead><tbody><tr><td>
          <p>'.$job->contract->name.'</p><p>'.$job->contract->address.'</p>
          <p>'.$job->contract->city.','.$job->contract->state.','.$job->contract->zip.'</p></td>';

          $html .= '</tr></tbody></table></div></td>';

          $html .= '<td><div class="invoice"><table width="100%" cellspacing="0" cellpadding="7" align="left"><thead><tr>
          <td><h4>Store :</h4></td></tr></thead><tbody><tr><td>
          <p>'.$job->site->name.'</p><p>'.$job->site->address.'</p>
          <p>'.$job->site->city.','.$job->site->state.','.$job->site->zip.'</p></td>';
          $html .= '</tr></tbody></table></div></td></tr></table><br/>
          <div ><table class="invoice" cellspacing="0" cellpadding="7" align="right" width="40%"><tbody><tr><th>Terms</th><th>Project</th></tr></tbody><tbody><tr><td>2% 10 Net 30</td><td>'.$job->site->name.'</td></tr></tbody></table></div></br></br></br></br><br/><br/><br/></br></br></br></br><br/><br/><br/>';
          $my_sum = 0.00;
          $html .= '<div class="invoice"><table cellspacing="0" align="center" width="100%"><thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr></thead><tbody>';
          foreach($job->services as $key => $service)
          {
            $html .= '<tr><td>'.$service->name.'</td><td>'.$service->description.'</td><td>1</td>';
            foreach($servicecosts as $key => $servicecost){
              if($servicecost->service_id == $service->id){
                $html .= '<td align="right">$'.number_format($servicecost->cost, 2).'</td><td align="right">$'.number_format($servicecost->cost, 2).'</td>';
                $my_sum = $my_sum + $servicecost->cost;
              }
            }
            $html .= '</tr>';
          }
          $html .= '</tbody><tfoot><tr><td colspan="3"></td><td align="left">Subtotal</td><td align="right" class="gray">$'.number_format($my_sum, 2).'</td></tr>';
          $my_tax = $my_sum * $job->site->tax_rate / 100.00;
          $html .= '<tr><th colspan="3"></th><td align="left">Sales Tax</td><td align="right" class="gray">$'.number_format($my_tax, 2).'</td></tr><tr><th colspan="3"></th><td align="left">Total</td><td align="right" class="gray">$'.number_format(($my_sum + $my_tax), 2).'</td></tr><tr><th colspan="3"></th><td align="left">Payments/Credits</td><td align="right" class="gray"> $0.00 </td></tr><tr><th colspan="3"></th><td align="left">Balance Due</td><td align="right" class="gray">$'.number_format(($my_sum + $my_tax), 2).'</td></tr></tfoot></table></div><div class="information" style="position: absolute; bottom: 0;"><table width="100%"><tr><td align="left" style="width: 50%;">&copy; (315)439-8842 - All rights reserved.</td><td align="right" style="width: 50%;">signaturenational@yahoo.com</td></tr></table></body>';
        }

     $html .= '</html>';
     $pdf = PDF::loadHTML($html);
     $name = 'pdf_'.$id.'.pdf';
     return $pdf->download($name);
   }

}
