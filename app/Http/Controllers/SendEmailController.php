<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Service;
use App\Site;
use App\Servicecost;
use App\Http\Controllers\Controller;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Job;
use App\Inv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class SendEmailController extends Controller
{
  public function send(Request $request)
  {



    //$ids = explode(",", $request['ids']);
    $ids = $request['ids'];
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
    foreach ($ids as $key => $id){
       $jobs = Job::where('id', $id)->get();
       foreach($jobs as $job){
         $date = strtotime($job->sign_create);
         $myNewDate = Date('m-d-Y H:i', $date);
         $db = mysqli_connect("localhost","signature","Fast2019!","signature");
         if (!$db) {
             die("Connection failed: " . mysqli_connect_error());
         }
         if($job->status == "Complete"){
           $sql = "UPDATE jobs SET status = 'Billed' WHERE id = $id";
           if (mysqli_query($db, $sql)) {
               error_log( "Record updated successfully");
           } else {
               error_log( "Error updating record: " . mysqli_error($db));
           }
           $job->load('contract', 'created_by');
           $job->load('site', 'created_by');
           $job->load('services');
           $html .= '<body><div class="pdfinformation"><table width="100%"><tr><td align="left" style="width: 40%;"><h3>Signature Window Cleaning Services</h3><h3>378 Westbrook Hills Dr.</h3><h3>Syracuse, NY 13215</h3><br/></td><td align="right" style="width: 40%;"><pre>Date: '.$myNewDate.'</pre></td></tr></table></div><br/><div class="pdfinformation" ><table width="100%"><tr><td align="left" style="width: 50%;"><h2>Bill To : '.$job->contract->name.'</h2><h2>Store : '.$job->site->name.'</h2></td></tr></table></div><div class="pdf"><h3>Service:</h3><table width="100%"><thead>';
           foreach($job->services as $key => $service)
           {
             $html .= '<tr><td align="left">'.$service->name.'</td></tr>';
           }
           $path = getcwd().'/IMAGE/'.$job->id.'.png';
           $html .= '</thead></table></div><div class="pdf" style="position: absolute; bottom: 0;"><table width="100%"><tr><td>Store Signature  </td><td> <img src='.$path.' alt="Logo" width="350" height="150" class="logo"/></td></tr></table></div></body>';

          $inv = 0;
          $invs = Inv::where('id', '1')->get();
          foreach ($invs as $key => $a){
            $inv = $a->inv_id;
          }
         $servicecosts = Servicecost::where('site_id', $job->site_id)->get();
         $job->load('contract', 'created_by');
         $job->load('site', 'created_by');
         $job->load('services');
         $html .= '<body><table width="100%" style="table-layout:fixed"><tr>
         <td  align="left"><h4>Signature Window Cleaning Services</h4>
         <b>378 Westbrook Hills Dr.</b><br/><br/><b>Syracuse, NY 13215</b></td>
         <td align="right"><h4>Invoice</h4><br/>
         <table class="invoice" cellspacing="0" cellpadding="7" style="margin-right:0px;margin-left:auto;"><tr><th>Date</th><th>Invoice#</th></tr><tr><td>'.$myNewDate.'</td>
         <td align="center">'.$inv.'</td></tr></table></td></tr></table><br/>
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
         $html .= '</tbody><tfoot><tr><td colspan="3"></td><td align="left">Subtotal</td><td align="right" class="gray">$'.number_format($my_sum, 3).'</td></tr>';
         $my_tax = $my_sum * $job->site->tax_rate / 100.00;
         $html .= '<tr><th colspan="3"></th><td align="left">Sales Tax</td><td align="right" class="gray">$'.number_format($my_tax, 3).'</td></tr><tr><th colspan="3"></th><td align="left">Total</td><td align="right" class="gray">$'.number_format(($my_sum + $my_tax), 3).'</td></tr><tr><th colspan="3"></th><td align="left">Payments/Credits</td><td align="right" class="gray"> $0.000 </td></tr><tr><th colspan="3"></th><td align="left">Balance Due</td><td align="right" class="gray">$'.number_format(($my_sum + $my_tax), 3).'</td></tr></tfoot></table></div><div class="information" style="position: absolute; bottom: 0;"><table width="100%"><tr><td align="left" style="width: 50%;">&copy; (315)439-8842 - All rights reserved.</td><td align="right" style="width: 50%;">signaturenational@yahoo.com</td></tr></table></div></body>';

         $sql = "UPDATE jobs SET inv_num = $inv WHERE id = $id";
         if (mysqli_query($db, $sql)) {
             error_log( "Record updated successfully");
         } else {
             error_log( "Error updating record: " . mysqli_error($db));
         }

         $inv = $inv + 1;
         $sql = "UPDATE invs SET inv_id = $inv WHERE id = '1'";
         if (mysqli_query($db, $sql)) {
             error_log( "Record updated successfully");
         } else {
             error_log( "Error updating record: " . mysqli_error($db));
         }



         mysqli_close($db);
       }
     }

    }
    $html .= '</html>';
    $pdf = PDF::loadHTML($html);
    //$pdf->render();
     $file = $pdf->output();
     $file_name = base_path()."/PDF/".'PDF';
    foreach ($ids as $key => $id) {
      $file_name .= '_'.$id;
    }
     $file_name .= '.pdf';
     //file_put_contents(base_path()."/PDF/".$file_name, $file);
     file_put_contents($file_name, $file);

     $this->validate($request,[
       'email'      =>      'required|email',
     ]);


      $mail = new PHPMailer(true); // notice the \  you have to use root namespace here
      $mail->isSMTP(); // tell to use smtp
      $mail->CharSet = "utf-8"; // set charset to utf8
      $mail->SMTPAuth = true;  // use smpt auth
      $mail->SMTPSecure = "tls"; // or ssl
      $mail->Host       = "smtpout.secureserver.net";
      $mail->Port       = 80; // most likely something different for you. This is the mailtrap.io port i use for testing.
      $mail->Username   = "invoice@signaturenational.com";
      $mail->Password   = "Fast2020!";
      $mail->setFrom("invoice@signaturenational.com");
      $mail->Subject = "Hello!";
      $mail->MsgHTML("This is a Invoice PDF");
      $mail->AddAttachment($file_name);
      $mail->addAddress($request['email']);

      if ($mail->Send()) {
        $this->statusdesc  =   "Message sent Succesfully";
        $this->statuscode  =   "1";
      } else {
        $this->statusdesc  =   "Error sending mail";
        $this->statuscode  =   "0";
      }
      return response()->json(compact('this'));
  }




}
