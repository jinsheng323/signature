@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.contract_.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.contract-s.update", [$contract_->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.contract_.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($contract_) ? $contract_->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                <label for="contact">{{ trans('cruds.contract_.fields.contact') }}*</label>
                <input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact', isset($contract_) ? $contract_->contact : '') }}" required>
                @if($errors->has('contact'))
                    <em class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.contact_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.contract_.fields.address') }}*</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($contract_) ? $contract_->address : '') }}" required>
                @if($errors->has('address'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.address_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                <label for="city">{{ trans('cruds.contract_.fields.city') }}*</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($contract_) ? $contract_->city : '') }}" required>
                @if($errors->has('city'))
                    <em class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.city_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                <label for="state">{{ trans('cruds.contract_.fields.state') }}*</label>
                <input type="text" id="state" name="state" class="form-control" value="{{ old('state', isset($contract_) ? $contract_->state : '') }}" required>
                @if($errors->has('state'))
                    <em class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.state_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                <label for="zip">{{ trans('cruds.contract_.fields.zip') }}*</label>
                <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', isset($contract_) ? $contract_->zip : '') }}" required>
                @if($errors->has('zip'))
                    <em class="invalid-feedback">
                        {{ $errors->first('zip') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.zip_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone">{{ trans('cruds.contract_.fields.phone') }}*</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($contract_) ? $contract_->phone : '') }}" required>
                @if($errors->has('phone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.phone_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('billingcontact') ? 'has-error' : '' }}">
                <label for="billingcontact">{{ trans('cruds.contract_.fields.billingcontact') }}*</label>
                <input type="text" id="billingcontact" name="billingcontact" class="form-control" value="{{ old('billingcontact', isset($contract_) ? $contract_->billingcontact : '') }}" required>
                @if($errors->has('billingcontact'))
                    <em class="invalid-feedback">
                        {{ $errors->first('billingcontact') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.billingcontact_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('billingemail') ? 'has-error' : '' }}">
                <label for="billingemail">{{ trans('cruds.contract_.fields.billingemail') }}*</label>
                <input type="text" id="billingemail" name="billingemail" class="form-control" value="{{ old('billingemail', isset($contract_) ? $contract_->billingemail : '') }}" required>
                @if($errors->has('billingemail'))
                    <em class="invalid-feedback">
                        {{ $errors->first('billingemail') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.billingemail_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('billingphone') ? 'has-error' : '' }}">
                <label for="billingphone">{{ trans('cruds.contract_.fields.billingphone') }}*</label>
                <input type="text" id="billingphone" name="billingphone" class="form-control" value="{{ old('billingphone', isset($contract_) ? $contract_->billingphone : '') }}" required>
                @if($errors->has('billingphone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('billingphone') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contract_.fields.billingphone_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('status_id') ? 'has-error' : '' }}">
                <label for="status">{{ trans('cruds.contract_.fields.status') }}</label>
                <select name="status_id" id="status" class="form-control select2">
                    @foreach($status_ as $id => $status)
                        <option value="{{ $id }}" {{ (isset($contract_) && $contract_->status ? $contract_->status->id : old('status_id')) == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status_id') }}
                    </em>
                @endif
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
