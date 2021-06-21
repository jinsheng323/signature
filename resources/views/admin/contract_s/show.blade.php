@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contract_.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.id') }}
                        </th>
                        <td>
                            {{ $contract_->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.name') }}
                        </th>
                        <td>
                            {{ $contract_->name }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.contact') }}
                        </th>
                        <td>
                            {{ $contract_->contact }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.address') }}
                        </th>
                        <td>
                            {{ $contract_->address }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.city') }}
                        </th>
                        <td>
                            {{ $contract_->city }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.state') }}
                        </th>
                        <td>
                            {{ $contract_->state }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.zip') }}
                        </th>
                        <td>
                            {{ $contract_->zip }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.phone') }}
                        </th>
                        <td>
                            {{ $contract_->phone }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.billingcontact') }}
                        </th>
                        <td>
                            {{ $contract_->billingcontact }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.billingemail') }}
                        </th>
                        <td>
                            {{ $contract_->billingemail }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.billingphone') }}
                        </th>
                        <td>
                            {{ $contract_->billingphone }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.contract_.fields.status') }}
                        </th>
                        <td>
                            {{ $contract_->status->name ?? '' }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div>
    </div>
</div>
@endsection
