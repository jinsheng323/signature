@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label for="username">{{ trans('cruds.user.fields.username') }}*</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username', isset($user) ? $user->username : '') }}" required>
                @if($errors->has('username'))
                    <em class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.username_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                <label for="firstname">{{ trans('cruds.user.fields.firstname') }}*</label>
                <input type="text" id="firstname" name="firstname" class="form-control" value="{{ old('firstname', isset($user) ? $user->firstname : '') }}" required>
                @if($errors->has('firstname'))
                    <em class="invalid-feedback">
                        {{ $errors->first('firstname') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.firstname_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                <label for="lastname">{{ trans('cruds.user.fields.lastname') }}*</label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="{{ old('lastname', isset($user) ? $user->lastname : '') }}" required>
                @if($errors->has('lastname'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lastname') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.lastname_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.user.fields.address') }}*</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($user) ? $user->address : '') }}" required>
                @if($errors->has('address'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.address_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                <label for="city">{{ trans('cruds.user.fields.city') }}*</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($user) ? $user->city : '') }}" required>
                @if($errors->has('city'))
                    <em class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.city_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                <label for="state">{{ trans('cruds.user.fields.state') }}*</label>
                <input type="text" id="state" name="state" class="form-control" value="{{ old('state', isset($user) ? $user->state : '') }}" required>
                @if($errors->has('state'))
                    <em class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.state_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                <label for="zip">{{ trans('cruds.user.fields.zip') }}*</label>
                <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', isset($user) ? $user->zip : '') }}" required>
                @if($errors->has('zip'))
                    <em class="invalid-feedback">
                        {{ $errors->first('zip') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.zip_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status_id">{{ trans('cruds.user.fields.status') }}</label>
                <select name="status_id" id="status" class="form-control select2">
                    @foreach($status_ as $id => $status)
                        <option value="{{ $id }}" {{ (isset($user) && $user->status ? $user->status->id : old('status')) == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status_id') }}
                    </em>
                @endif
            </div>



            <div class="form-group {{ $errors->has('phonenumber') ? 'has-error' : '' }}">
                <label for="phonenumber">{{ trans('cruds.user.fields.phonenumber') }}*</label>
                <input type="text" id="phonenumber" name="phonenumber" class="form-control" value="{{ old('phonenumber', isset($user) ? $user->phonenumber : '') }}" required>
                @if($errors->has('phonenumber'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phonenumber') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.phonenumber_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" >
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <em class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
