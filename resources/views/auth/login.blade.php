@extends('layouts.login')


@section('content')
    <div class="m-login__logo">
        <a href="#">
            {{--<img src="{{asset('images/logo/logo.png') }}">--}}
        </a>
    </div>
    <div class="m-login__signin">
        <div class="m-login__head">
            <h3 class="m-login__title">
                Iniciar sesión
            </h3>
        </div>
        <form class="m-login__form m-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group m-form__group {{$errors->has('email')? 'has-danger': ''}}">
                <input class="form-control m-input" type="text" placeholder="Email" name="email"
                       autocomplete="off" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <div class="form-control-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group {{$errors->has('password') ? 'has-danger': ''}}">
                <input class="form-control m-input m-login__form-input--last" type="password"
                       placeholder="Contraseña" name="password">
                @if ($errors->has('password'))
                    <div class="form-control-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="row m-login__form-sub">
                <div class="col m--align-left">
                    <label class="m-checkbox m-checkbox--focus">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Recordarme
                        <span></span>
                    </label>
                </div>
{{--                <div class="col m--align-right">--}}
{{--                    <a href="{{ route('password.request') }}" class="m-link">--}}
{{--                        Forget Password ?--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
            <div class="m-login__form-action">
                <button id="m_login_signin_submit" type="submit"
                        class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                    Ingresar
                </button>
            </div>
        </form>
    </div>

@endsection
