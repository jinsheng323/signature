@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.site.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.sites.update", [$site->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('contract_id') ? 'has-error' : '' }}">
                <label for="contract">{{ trans('cruds.site.fields.contract') }}</label>
                <select name="contract_id" id="contract" class="form-control select2">
                    @foreach($contracts as $id => $contract)
                        <option value="{{ $id }}" {{ (isset($site) && $site->contract ? $site->contract->id : old('contract_id')) == $id ? 'selected' : '' }}>{{ $contract }}</option>
                    @endforeach
                </select>
                @if($errors->has('contract_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('contract_id') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                <label for="services">{{ trans('cruds.site.fields.service') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="services[]" id="services" class="form-control select2" multiple="multiple" required>
                    @foreach($services as $id => $services)
                        <option value="{{ $id }}" {{ (in_array($id, old('services', [])) || isset($site) && $site->services->contains($id)) ? 'selected' : '' }}>{{ $services }}</option>
                    @endforeach
                </select>
                @if($errors->has('services'))
                    <em class="invalid-feedback">
                        {{ $errors->first('services') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.site.fields.service_helper') }}
                </p>
            </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">{{ trans('cruds.site.fields.name') }}*</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($site) ? $site->name : '') }}"  required>
                            @if($errors->has('name'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.name_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address">{{ trans('cruds.site.fields.address') }}</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($site) ? $site->address : '') }}">
                            @if($errors->has('address'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.address_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                            <label for="city">{{ trans('cruds.site.fields.city') }}</label>
                            <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($site) ? $site->city : '') }}">
                            @if($errors->has('city'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.city_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                            <label for="state">{{ trans('cruds.site.fields.state') }}</label>
                            <input type="text" id="state" name="state" class="form-control" value="{{ old('state', isset($site) ? $site->state : '') }}">
                            @if($errors->has('state'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.state_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                            <label for="zip">{{ trans('cruds.site.fields.zip') }}</label>
                            <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', isset($site) ? $site->zip : '') }}">
                            @if($errors->has('zip'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('zip') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.zip_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="phone">{{ trans('cruds.site.fields.phone') }}</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($site) ? $site->phone : '') }}">
                            @if($errors->has('phone'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.phone_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('sitecontact') ? 'has-error' : '' }}">
                            <label for="sitecontact">{{ trans('cruds.site.fields.sitecontact') }}</label>
                            <input type="text" id="sitecontact" name="sitecontact" class="form-control" value="{{ old('sitecontact', isset($site) ? $site->sitecontact : '') }}">
                            @if($errors->has('sitecontact'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('sitecontact') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.sitecontact_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                            <label for="notes">{{ trans('cruds.site.fields.notes') }}</label>
                            <input type="text" id="notes" name="notes" class="form-control" value="{{ old('notes', isset($site) ? $site->notes : '') }}">
                            @if($errors->has('notes'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('notes') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.notes_helper') }}
                            </p>
                        </div>

                        <div class="form-group {{ $errors->has('tax_rate') ? 'has-error' : '' }}">
                            <label for="tax_rate">{{ trans('cruds.site.fields.tax_rate') }}</label>
                            <input type="text" id="tax_rate" name="tax_rate" class="form-control" value="{{ old('tax_rate', isset($site) ? $site->tax_rate : '') }}">
                            @if($errors->has('tax_rate'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('tax_rate') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.site.fields.tax_rate_helper') }}
                            </p>
                        </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
