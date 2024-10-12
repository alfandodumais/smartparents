@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="row justify-content-center">
        <div class="col-md-18">
            <div class="card shadow-lg p-5" style="border-radius: 25px;">
                <div class="text-center mb-2">
                    <!-- Logo Text -->
                    <h1 style="font-size: 2.5rem; font-weight: bold; color: #3C8DBC;">SmartParents.id</h1>
                    <p style="font-size: 1.2rem; color: #6c757d;">Welcome Back! Please Login to Your Account</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="col-form-label text-md-right">{{ __('Email Address') }}</label>
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                            <div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" style="background-color: #3C8DBC;">
                                    {{ __('Log In') }}
                                </button>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
