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


class PDFController extends Controller
{

    /**

    * Display a listing of the resource.

    *

    * @return \Illuminate\Http\Response

    */



  public function generatepay(Request $request)
   {
     $ids = $_GET['ids'];
     $date = $_GET['date'];

     $check_number = $_GET['check_number'];

     $db = mysqli_connect("localhost","root","","signature");
     foreach ($ids as $key => $id){
       if (!$db) {
           die("Connection failed: " . mysqli_connect_error());
       }
       $jobs = Job::where('id', $id)->get();
       foreach ($jobs as $key => $job) {
         if($job->status == "Billed"){
           $sql = "UPDATE jobs SET status = 'Payed', pay_date = '$date', check_number = '$check_number' WHERE id = $id";
           if (mysqli_query($db, $sql)) {
               error_log( "Record updated successfully");
           } else {
               error_log( "Error updating record: " . mysqli_error($db));
           }
         }
       }
    }
     mysqli_close($db);
     return response()->json(compact('this'));
   }



}
