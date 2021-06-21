<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>

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
            font-size: small solid #c8ced3;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 10px;
        }
        .invoice tfoot {
          border-top: 2px solid #c8ced3;
        }
        .invoice h3 {
            margin-left: 10px;
            margin-right: 10px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 8px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
              <h3>Signature Window Cleaning Services</h3>
              <h3>378 Westbrook Hills Dr.</h3>
              <h3>Syracuse, NY 13215</h3>
              <br/>
            </td>
            <td align="right" style="width: 40%;">
                <h3>Invoice</h3>
                <br/>
                <h3>
                  <table align="right" width="60%" >
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Invoice#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{$job->created_at}}</td>
                          <td>{{$inv}}</td>
                        </tr>
                      </tbody>
                  </table>
                </h3>
                <br/>
            </td>
        </tr>
    </table>
</div>
<br/>

<div class="invoice">
  <table width="100%">
    <thead>
    <tr>
        <td align="left" style="width: 40%;">
          <h3>Bill To</h3>
          <h3>{{$job->contract->name}}</h3>
          <h3>{{$job->contract->address}}</h3>
          <h3>{{$job->contract->city}}, {{$job->contract->state}}, {{$job->contract->zip}}</h3>
        </td>
      <td align="right" style="width: 40%;">
        <h3>Store To</h3>
        <h3>{{$job->site->name}}</h3>
        <h3>{{$job->site->address}}</h3>
        <h3>{{$job->site->city}}, {{$job->site->state}}, {{$job->site->zip}}</h3>
      </td>
    </tr>
  </thead>
  </table>
</div>
<div >
  <table align="right" width="40%" >
      <thead>
        <tr>
          <th>Terms</th>
          <th>Project</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2% 10 Net 30</td>
          <td>{{$job->site->name}}</td>
        </tr>
      </tbody>
  </table>
</div>
</br>
</br>
<br/>
<br/><br/>
<?php  $my_sum = 0 ?>
<div class="invoice">
    <table width="100%">
        <thead>
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
          @foreach($job->services as $key => $service)
            <tr>
                <td>{{$service->name}}</td>
                <td>{{$service->description}}</td>
                <td>1</td>

                @foreach($servicecosts as $key => $servicecost)
                  @if($servicecost->service_id == $service->id)
                  <td>{{$servicecost->cost}}</td><td>{{$servicecost->cost}}</td>
                  <?php $my_sum = $my_sum + $servicecost->cost ?>
                  @endif
                @endforeach
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
              <td colspan="3"></td>
              <td align="left">Subtotal</td>
              <td align="left" class="gray">{{$my_sum}}</td>
          </tr>
          <?php $my_tax = $my_sum * $job->site->tax_rate ?>
          <tr>
              <td colspan="3"></td>
              <td align="left">Sales Tax</td>
              <td align="left" class="gray">{{$my_tax}}</td>
          </tr>
          <tr>
              <td colspan="3"></td>
              <td align="left">Total</td>
              <td align="left" class="gray">{{$my_tax + $my_sum}}</td>
          </tr>
          <tr>
              <td colspan="3"></td>
              <td align="left">Payments/Credits</td>
              <td align="left" class="gray">$0.00</td>
          </tr>
          <tr>
              <th colspan="3"></th>
              <th align="left">Balance Due</th>
              <th align="left" class="gray">{{$my_tax + $my_sum}}</th>
          </tr>
        </tfoot>
    </table>
</div>

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; (315)439-8842 - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                signaturenational@yahoo.com
            </td>
        </tr>

    </table>
</div>
</body>
</html>
