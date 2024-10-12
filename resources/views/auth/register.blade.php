@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="row justify-content-center">
        <div class="col-md-18">
            <div class="card shadow-lg p-4" style="border-radius: 15px;">
                <div class="text-center mb-4">
                    <!-- Logo Text -->
                    <h1 style="font-size: 2.5rem; font-weight: bold; color: #3C8DBC;">SmartParents.id</h1>
                    <p style="font-size: 1.2rem; color: #6c757d;">Create Your Account</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                            <div>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="col-form-label text-md-right">{{ __('Email Address') }}</label>
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                    required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password-confirm"
                                class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" style="background-color: #3C8DBC;">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
