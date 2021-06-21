@extends('layouts.jobmain')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("jobs.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.job.title_singular') }}
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.job.title_singular') }} {{ trans('global.list') }}
    </div>

    <div align="center">
      <form action="{{ route("jobs.filter") }}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="form-inline" >
          <div class="form-group mx-sm-3 mb-2">
            <label for="contract">{{ trans('cruds.job.fields.contract') ." : " }}</label>
            <select name="contract_id" id="filter_contract" class="form-control" >
                <option value="">Select Please...</option>
                @foreach($contracts as $id => $contract)
                <option value="{{$id}}">{{$contract}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <label for="site">{{ trans('cruds.job.fields.site') ." : " }}</label>
            <select name="site_id" id="filter_site" class="form-control" >
              <option value="">Select Please...</option>
                @foreach($sites as $id => $site)
                <option value="{{$id}}">{{$site}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <label for="status">{{ trans('cruds.job.fields.status') ." : "}}</label>
            <select name="filter_status" id="filter_status" class="form-control" >
                <option value="">Select Please...</option>
                @foreach($status_ as $status)
                <option value="{{$status}}">{{$status}}</option>
                @endforeach
            </select>
          </div>
          <div class="row input-daterange">
            <div class="form-group mx-sm-3 mb-2">
              <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
            </div>
          </div>
          <div class="form-group mx-sm-3 mb-2" >
            <input name="filter" id="filter" class="btn btn-info" type="submit" value="Filter"/>
          </div>
      </form>
          <div class="form-group mx-sm-3 mb-2" >
            <a href="{{ route('jobs.index') }}" class="btn btn-info" role="button" >
              Reset
            </a>
          </div>
    </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" >
            <table  class=" table table-bordered table-striped table-hover datatable datatable-Job">
                <thead>
                    <tr>
                        <th >

                        </th>
                        <th>
                            {{ trans('cruds.job.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.job.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.job.fields.contract') }}
                        </th>
                        <th>
                            {{ trans('cruds.job.fields.site') }}
                        </th>
                        <th class="servicesize">
                            {{ trans('cruds.job.fields.service') }}
                        </th>
                        <th>
                            {{ trans('cruds.job.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.job.fields.created_date') }}
                        </th>

                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="showfilter">
                    @foreach($jobs as $key => $job)
                        <tr data-entry-id="{{ $job->id }}">
                            <td></td>
                            <td>
                                {{ $job->id ?? '' }}
                            </td>
                            <td>
                                {{ $job->name ?? '' }}
                            </td>
                            <td>
                                {{ $job->contract->name ?? '' }}
                            </td>
                            <td>
                                {{ $job->site->name ?? '' }}
                            </td>
                            <td class="servicesize">
                              @foreach($job->services as $key => $item)
                                  <span class="badge badge-info">{{ $item->name }}</span>
                              @endforeach
                            </td>
                            <td>
                                {{ $job->status ?? '' }}
                            </td>
                            <td>
                              <?php $date = strtotime($job->created_at);
                              $myNewDate = Date('m-d-Y H:i', $date); ?>
                                {{ $myNewDate ?? '' }}
                            </td>
                            <td>
                              @if($job->status == "Pending")
                                    <a class="fa fa-pencil" href="{{ route('jobs.show', $job->id) }}">
                                    </a>
                              @endif
                                    <a class="fa fa-eye" href="{{ route('jobs.edit', $job->id) }}">
                                    </a>
                              @if($job->status == "Billed")
                                    <a class="fa fa-file-o" href="{{ action('Job\JobController@generatebill', $job->id) }}">
                                    </a>
                              @endif
                              @if($job->status == "Payed")
                                    <a class="fa fa-file-o" href="{{ action('Job\JobController@generatebill', $job->id) }}">
                                    </a>
                                    <a class="fas fa-hand-holding-usd" style="color:green" id="payinfo" href="" >
                                    </a>

                              @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-body" style="padding:40px 50px;">
           <div class="form-group">
             <div class="form-group">
               <label for="date"><span class="glyphicon glyphicon-user"></span> Date</label>
               <input type="date" name="date" id="date" class="form-control" placeholder="Date" required/>
             </div>
           </div>
           <div class="form-group">
             <label for="check_number"><span class="glyphicon glyphicon-eye-open"></span> Check Number</label>
             <input type="text" class="form-control" name="check_number" id="check_number" placeholder="Check number">
           </div>
             <button type="submit" id='save' class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>Save</button>

       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
       </div>
     </div>

   </div>
 </div>

 <div id="modalpay" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div id="pay-info" class="modal-body"></div>
               <div id="orderItems" class="modal-body"></div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Back</button>
          </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  @can('job_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('jobs.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')
        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

@can('job_bill')

let pdfButton = {
  text: 'Bill',
  url: "{{ route('sendmail') }}",
  className: 'btn-info',
  id:'bill',
  action: function (e, dt, node, config) {
    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
        return $(entry).data('entry-id')
    });
    if (ids.length == 0) {
      alert('{{ trans('global.datatables.zero_selected') }}')
      return
    }
    var email='';
    var jobs = <?php echo json_encode($jobs); ?>;
      for (var i = 0; i < jobs.length; i++) {
        for (var j = 0; j < ids.length; j++) {
          if(jobs[i].id == ids[j])
          {
            if(jobs[i].status != 'Complete')
            {
              alert('select Complete jobs')
              return;
            }
            email = jobs[i].contract.billingemail;
          }
        }
      }

      $.ajax({
        headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        method: 'get',
        url: '{{ route('sendmail') }}',
        dataType: 'json',
          data: {email:email, ids:ids},
          success: function(response) {
            alert('successfully sent');
              window.location.reload();
          },
          error: function(err) {
               console.log('error:' + err);
           }
      });


    }
  }
  dtButtons.push(pdfButton)




let payButton = {
text: 'Pay',
url: "{{ route('generatepay') }}",
className: 'btn-info',
action: function (e, dt, node, config) {
  var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
      return $(entry).data('entry-id')
  });
  if (ids.length == 0) {
    alert('{{ trans('global.datatables.zero_selected') }}')
    return
  }
  var jobs = <?php echo json_encode($jobs); ?>;
  if (confirm('{{ trans('global.areYouSure') }}')) {
    for (var i = 0; i < jobs.length; i++) {
      for (var j = 0; j < ids.length; j++) {
        if(jobs[i].id == ids[j])
        {
          if(jobs[i].status != 'Billed')
          {
            alert('select Billed jobs')
            return;
          }
        }
      }
    }

      $("#myModal").modal();
      
      document.getElementById('save').addEventListener("mouseup", function(e) {

        $.ajax({
          headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
          method: 'GET',
          url: '{{ route('generatepay') }}',
          dataType: 'json',
            data: {ids:ids, date:$("#date").val(), check_number:$("#check_number").val()},
            success: function(response) {
                window.location.reload();
            },
            error: function(e) {
                 console.log('error:' + e);
             }
        });
      });

    }
  }
}
dtButtons.push(payButton)
@endcan



  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Job').DataTable({ buttons: dtButtons });
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

$(function () {
        $("a[id='payinfo']").click(function () {

          var getIdFromRow = $(event.target).closest('tr').data('entry-id');
          var jobs = <?php echo json_encode($jobs); ?>;
          for (var i = 0; i < jobs.length; i++) {
            if(jobs[i].id == getIdFromRow)
            {
              date = new Date(jobs[i].pay_date);

               var result = ((date.getMonth().toString().length > 1) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate().toString().length > 1) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
              $("#modalpay").find("#pay-info").html($('<b> Date : ' + result  + '</b><br/><b> Check Number : ' + jobs[i].check_number + '</b>'  ))
            }
          }

          $("#modalpay").modal("show");
          return false;
        });
    });



</script>
@endsection
