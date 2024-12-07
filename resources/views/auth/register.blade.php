@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Fields -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Mobile Money Phone -->
                        <div class="row mb-3">
                            <label for="mobile-money-phone" class="col-md-4 col-form-label text-md-end">{{ __('Mobile Money Phone') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="mobile-money-phone"
                                    type="text"
                                    class="form-control @error('mobile_money_phone') is-invalid @enderror"
                                    name="mobile_money_phone"
                                    value="{{ old('mobile_money_phone') }}"
                                    required
                                    autocomplete="mobile-money-phone"
                                    placeholder="+254712345678">
                                @error('mobile_money_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Mobile Money Network -->
                        <div class="row mb-3">
                            <label for="mobile-money-network" class="col-md-4 col-form-label text-md-end">{{ __('Mobile Money Network') }}</label>
                            <div class="col-md-6">
                                <select
                                    id="mobile-money-network"
                                    class="form-control @error('mobile_money_network') is-invalid @enderror"
                                    name="mobile_money_network"
                                    required>
                                    <option value="" disabled selected>{{ __('Select Network') }}</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="airtel">Airtel Money</option>
                                    <option value="tigo">Tigo Pesa</option>
                                    <option value="orange">Orange Money</option>
                                    <option value="mtn">MTN Mobile Money</option>
                                </select>
                                @error('mobile_money_network')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
