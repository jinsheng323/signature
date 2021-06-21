@extends('layouts.jobmain')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.job.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.job.fields.id') }}
                        </th>
                        <td>
                            {{ $job->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.job.fields.name') }}
                        </th>
                        <td>
                            {{ $job->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.job.fields.contract') }}
                        </th>
                        <td>
                            {{ $job->contract->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.job.fields.site') }}
                        </th>
                        <td>
                            {{ $job->site->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.job.fields.service') }}
                        </th>
                        <td>
                            @foreach($job->services as $id => $services)
                                <span class="label label-info label-many">{{ $services->name }}{{','}}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            @if($job->signpath != '/')
                <img src={{$job->signpath}}  width="400" height="200">
            @endif


            <a id="btn1" class="btn btn-default" href="{{ url()->previous() }}" style="display:true">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
