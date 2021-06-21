@extends('layouts.jobmain')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.job.title') }}
    </div>

    <div class="card-body">
      <form action="{{ route("jobs.update", [$job->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name">{{ trans('cruds.job.fields.name') }}*</label>
              <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($job) ? $job->name : '') }}" required>
              @if($errors->has('name'))
                  <em class="invalid-feedback">
                      {{ $errors->first('name') }}
                  </em>
              @endif
              <p class="helper-block">
                  {{ trans('cruds.job.fields.name_helper') }}
              </p>
          </div>

          <div class="form-group {{ $errors->has('contract_id') ? 'has-error' : '' }}">
              <label for="contract">{{ trans('cruds.job.fields.contract') }}</label>
              <select name="contract_id" id="contract" class="form-control select2" >

                  @foreach($contracts as $id => $contract)
                      <option value="{{ $id }}" {{ (isset($job) && $job->contract ? $job->contract->id : old('contract_id')) == $id ? 'selected' : '' }}>{{ $contract }}</option>
                  @endforeach
              </select>

          </div>

            <div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
                <label for="site">{{ trans('cruds.job.fields.site') }}</label>
                <select name="site_id" id="site" class="form-control select2">
                  @foreach($sites as $id => $site)
                      <option value="{{ $id }}"  {{ (isset($job) && $job->site ? $job->site->id : old('site_id')) == $id ? 'selected' : '' }}>{{ $site }}</option>
                  @endforeach
                </select>
                @if($errors->has('site_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('site_id') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
                 <label for="service">{{ trans('cruds.job.fields.service') }}
                 <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                 <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                 <select name="services[]" id="service" class="form-control select2" multiple="multiple" required>
                   @foreach($services as $id => $services)
                       <option value="{{ $id }}" {{ (in_array($id, old('services', [])) || isset($job) && $job->services->contains($id)) ? 'selected' : '' }}>{{ $services }}</option>
                   @endforeach
                 </select>
                 @if($errors->has('service_id'))
                     <em class="invalid-feedback">
                         {{ $errors->first('service_id') }}
                     </em>
                 @endif
             </div>

             <a>
                 <input id="btn1" class="btn btn-danger" type="submit" value="{{ trans('global.save') }}" style="display:true">
             </a>
      </form>
      <div class="col-sm-9 col-md-10 view-message"  style="display:none">
        <div class="wrapper mb-3">
          <canvas id="signature-pad" class="signature-pad" width=400 height=200 required name="signature"></canvas>
        </div>
      </div>

      <a>
          <input id="btn2" class="btn btn-info" type="submit" value="{{ trans('Get Sign') }}" style="display:true">
      </a>


      <div class="col-sm-9 col-md-10 view-message"  style="display:none">
        <a>
            <input id="btn3" class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
        </a>
      </div>
      <a id="btn1" class="btn btn-default" href="{{ url()->previous() }}" style="display:true">
          {{ trans('global.back_to_list') }}
      </a>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var canvas = document.querySelector("canvas");

        var signaturePad = new SignaturePad(canvas, {
           backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        $("#contract").change(function(){
            $.ajax({
                url: "{{ route('admin.sites.sitefilter') }}?contract_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#site').html(data.html);
                }
            });
        });
        $("#site").change(function(){
            $.ajax({
                url: "{{ route('admin.services.servicefilter') }}?site_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#service').html(data.html);
                }
            });
        });

        $("#btn2").click(function() {
              $("#btn1").fadeOut('slow').css('display','none');
              $("#btn2").fadeOut('slow').css('display','none');
              $(".view-message").fadeIn('slow').css('diplay','true');
        });

        $("#btn3").click(function() {
            if (canvas.isEmpty) {
              return alert("Please provide a signature first.");
            }
            else{
              var dataURL = canvas.toDataURL();
              var output=dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
              var job= {{ $job->id }} + "," + output;
              
              $.ajax({
                  headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                  url: "{{ route('jobs.resavesign') }}",
                  data:{job:job},
                  type: 'post',
                  dataType: 'json',
                success: function (response) {
                  window.location.href = "/";
                },
                error: function(err) {
                     console.log('error:' + err);
                 }
              });
            }
          });

    </script>


@endsection
