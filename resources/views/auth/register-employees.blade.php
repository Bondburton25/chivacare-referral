@extends('layouts.app')

@section('pageTitle', __('Register employee'))

@section('stylesheet')

<style>
    .btn-line {
        background: #06C755!important;
        color: #FFF!important;
    }
    #user-image {
        width: 120px;
        height: 120px;
        margin-top: -85px;
        border: 4px solid #CCC;
    }
</style>

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-12">
            <div class="card border-0 shadow-sm">
                <img src="{{ asset('images/operator-woman.webp') }}" class="border-0 link-opacity-10-hover" alt="">
                <div class="card-body py-4">
                    <img src="" alt="user-line" id="user-image" class="rounded mx-auto d-block rounded-circle mb-2">
                    @error('provider_id')
                        <div class="alert alert-danger border-0 text-center" role="alert">
                            <div class="d-block">{{ __('Your LINE account has already been registered with us') }} </div>
                            {{ __('You can go to the page') }} <a href="{{ route('login') }}" class="text-reset">{{ __('Login') }}</a> {{ __('right away') }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('register.line.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="role" value="employee">

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus>
                                @error('phone_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="occupation" class="col-md-4 col-form-label text-md-end">{{ __('Occupation') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation" autofocus>
                                @error('line_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="line_id" class="col-md-4 col-form-label text-md-end">{{ __('Affiliation') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="affiliation" name="affiliation">
                                @error('affiliation')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" id="lineUserid" name="provider_id">
                        <input type="hidden" id="name" name="name">
                        <input type="hidden" id="avatar" name="avatar">

                        <div class="row mb-0 mt-5">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg btn-line">
                                    {{ __('Register with the LINE account') }}
                                </button>
                            </div>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

<script src="https://static.line-scdn.net/liff/edge/versions/2.15.0/sdk.js"></script>
<script>
    function runApp() {
        liff.getProfile().then(profile => {
            document.getElementById("lineUserid").value = profile.userId;
            document.getElementById("first_name").value = profile.displayName;
            document.getElementById("name").value = profile.displayName;
            document.getElementById("avatar").value = profile.pictureUrl;
            document.getElementById("user-image").src = profile.pictureUrl;
        }).catch(err => console.error(err));
    }
    // liffID for Production  = 2000626016-3m0YB8zW
    // liffID for Development = 2000588475-9dGzkaw3
    liff.init({ liffId: "2000588475-9dGzkaw3" }, () => {
        if (liff.isLoggedIn()) {
          runApp();
        } else {
          liff.login();
        }
    }, err => console.error(err.code, error.message));
</script>

@endsection
