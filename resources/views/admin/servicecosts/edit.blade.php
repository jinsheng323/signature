@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.servicecost.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.servicecosts.update", [$servicecost->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
                <label for="site">{{ trans('cruds.servicecost.fields.site') }}</label>
                <select name="site_id" id="site" class="form-control select2">
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (isset($servicecost) && $servicecost->site ? $servicecost->site->id : old('site_id')) == $id ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('site_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('site_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
                <label for="service">{{ trans('cruds.servicecost.fields.service') }}</label>
                <select name="service_id" id="service" class="form-control select2">
                    @foreach($services as $id => $service)
                        <option value="{{ $id }}" {{ (isset($servicecost) && $servicecost->service ? $servicecost->service->id : old('service_id')) == $id ? 'selected' : '' }}>{{ $service }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('service_id') }}
                    </em>
                @endif
            </div>


            <div class="form-group {{ $errors->has('cost') ? 'has-error' : '' }}">
                <label for="cost">{{ trans('cruds.servicecost.fields.cost') }}</label>
                <input type="text" id="cost" name="cost" class="form-control" value="{{ old('cost', isset($servicecost) ? $servicecost->cost : '') }}">
                @if($errors->has('cost'))
                    <em class="invalid-feedback">
                        {{ $errors->first('cost') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.servicecost.fields.cost_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
