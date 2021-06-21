<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App;
use App\Payment;
use App\Job;


class PaymentController extends Controller
{
  public function store(Request $request)
  {
    Payment::create($request->all());
  //  $service = Job::create($request->all());
  //  $site = Job::create($request->all());
    return redirect()->route('jobs.index');
  }
}
