@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.site.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.id') }}
                        </th>
                        <td>
                            {{ $site->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.name') }}
                        </th>
                        <td>
                            {{ $site->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.contract') }}
                        </th>
                        <td>
                            {{ $site->contract->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.address') }}
                        </th>
                        <td>
                            {{ $site->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.city') }}
                        </th>
                        <td>
                            {{ $site->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.state') }}
                        </th>
                        <td>
                            {{ $site->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.zip') }}
                        </th>
                        <td>
                            {{ $site->zip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.phone') }}
                        </th>
                        <td>
                            {{ $site->phone }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.service') }}
                        </th>
                        <td>
                            @foreach($site->services as $id => $services)
                                <span class="label label-info label-many">{{ $services->name }}{{','}}</span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.sitecontact') }}
                        </th>
                        <td>
                            {{ $site->sitecontact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.notes') }}
                        </th>
                        <td>
                            {{ $site->notes }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.tax_rate') }}
                        </th>
                        <td>
                            {{ $site->tax_rate }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
