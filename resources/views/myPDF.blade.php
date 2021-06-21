<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Contract;
use App\Service;
use App\Site;
use App\Servicecost;
use App\Http\Controllers\Controller;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App;
use PDF;
use App\Inv;



class PDFController extends Controller

{

    /**

    * Display a listing of the resource.

    *

    * @return \Illuminate\Http\Response

    */

    public function generatePDF(Request $request)
   {
     $ids = explode(",", $_GET['ids']);
     $head1 = '<!doctype html>
              <html lang="en">
              <head>
                  <meta charset="UTF-8">
                  <title>Sign Off</title>
                  <style type="text/css">
                      @page {
                          margin: 0px;
                      }
                      body {
                          margin: 0px;
                      }
                      * {
                          font-family: Verdana, Arial, sans-serif;
                      }
                      a {
                          color: #fff;
                          text-decoration: none;
                      }
                      table {
                          font-size: 20px;
                      }
                      tfoot tr td {
                          font-weight: bold;
                          font-size: x-small;
                      }
                      .invoice table {
                          margin: 15px;
                      }
                      .invoice h3 {
                          margin-left: 15px;
                      }
                      .information {
                          background-color: #60A7A6;
                          color: #FFF;
                      }
                      .invoice .logo {
                          margin: 5px;
                      }
                      .information table {
                          padding: 30px;
                      }
                  </style>
              </head>';
     $html = $head1;
     $inv = 0;
     $invs = Inv::where('id', '1')->get();
     foreach ($invs as $key => $a){
       $inv = $a->inv_id;
     }
     foreach ($ids as $key => $id){
        $job = Job::where('id', $id)->get();
        foreach($job as $job){
          $servicecosts = Servicecost::where('site_id', $job->site_id)->get();
          $job->load('contract', 'created_by');
          $job->load('site', 'created_by');
          $job->load('services');
          $html .= '<body><div class="information"><table width="100%"><tr><td align="left" style="width: 40%;"><h3>Signature Window Cleaning Services</h3><h3>378 Westbrook Hills Dr.</h3><h3>Syracuse, NY 13215</h3><br/></td><td align="right" style="width: 40%;"><pre>Date: '.$job->created_at.'</pre></td></tr></table></div><br/><div class="information" ><table width="100%"><tr><td align="left" style="width: 50%;"><pre>Bill To : '.$job->contract->name.'</pre><pre>Store : '.$job->site->name.'</pre></td></tr></table></div><div class="invoice"><h3>Service</h3><table width="100%"><thead>';
          foreach($job->services as $key => $service)
          {
            $html .= '<tr><td align="Center">'.$service->name.'</td></tr>';
          }
          $html .= '</thead></table></div><div class="invoice" style="position: absolute; bottom: 0;"><table width="100%"><tr><td>Store Signature :</td><td> <img src="'.$job->id.'.png"'.'alt="Logo" width="350" height="150" class="logo"/></td></tr></table></div></body>';
        }
     }
     $html .= '</html>';
     $pdf = PDF::loadHTML($html);
      $sheet = $pdf->setPaper('a4');
      $r = $sheet->stream('download.pdf');
      return $r;
   }

   public function generatebill(Request $request)
    {
      $ids = $_GET['ids'];
      $db = mysqli_connect("localhost","signature","Fast2019!","signature");
      foreach ($ids as $key => $id){
        $job = Job::all()->where('id', $id);
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "UPDATE jobs SET status = 'Billed' WHERE id = $id";
        if (mysqli_query($db, $sql)) {
            error_log( "Record updated successfully");
        } else {
            error_log( "Error updating record: " . mysqli_error($db));
        }
      }
      mysqli_close($db);
      $html = "";
      return response()->json(['html' => $html]);
    }

  public function generatepay(Request $request)
   {
     $ids = $_GET['ids'];
     $db = mysqli_connect("localhost","signature","Fast2019!","signature");
     foreach ($ids as $key => $id){
       $job = Job::all()->where('id', $id);
       if (!$db) {
           die("Connection failed: " . mysqli_connect_error());
       }
       $sql = "UPDATE jobs SET status = 'Payed' WHERE id = $id";
       if (mysqli_query($db, $sql)) {
           error_log( "Record updated successfully");
       } else {
           error_log( "Error updating record: " . mysqli_error($db));
       }
     }
     mysqli_close($db);
     $html = "";
     return response()->json(['html' => $html]);
   }



}
