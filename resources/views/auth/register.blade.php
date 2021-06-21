@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card mx-4">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <h1>{{ trans('panel.site_title') }}</h1>
                    <p class="text-muted">{{ trans('global.register') }}</p>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.user_name') }}" value="{{ old('username', null) }}">
                        @if($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="firstname" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('First Name') }}" value="{{ old('firstname', null) }}">
                        @if($errors->has('firstname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('firstname') }}
                            </div>
                        @endif

                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="lastname" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('Last Name') }}" value="{{ old('lastname', null) }}">
                        @if($errors->has('lastname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('lastname') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope fa-fw"></i>
                            </span>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            </span>
                        </div>
                        <input type="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" required placeholder="{{ trans('Address') }}" value="{{ old('address', null) }}">
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif

                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            </span>
                        </div>
                        <input type="city" name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" required placeholder="{{ trans('City') }}" value="{{ old('city', null) }}">
                        @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('city') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            </span>
                        </div>
                        <input type="state" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" required placeholder="{{ trans('State') }}">
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif

                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            </span>
                        </div>
                        <input type="zip" name="zip" class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}" required placeholder="{{ trans('Zip') }}">
                        @if($errors->has('zip'))
                            <div class="invalid-feedback">
                                {{ $errors->first('zip') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            </span>

                        <select name="status_id" id="status" class="form-control select2">
                            <option value="{{ 1 }}" >{{ 'enable' }}</option>
                            <option value="{{ 2 }}" >{{ 'disable' }}</option>
                        </select>

                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                      </div>

                      <div class="input-group-prepend">
                          <span class="input-group-text">
                          </span>
                      </div>
                      <input type="phonenumber" name="phonenumber" class="form-control{{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" required placeholder="{{ trans('Phonenumber') }}">
                      @if($errors->has('phonenumber'))
                          <div class="invalid-feedback">
                              {{ $errors->first('phonenumber') }}
                          </div>
                      @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>

                    <button class="btn btn-block btn-primary">
                        {{ trans('global.register') }}
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
