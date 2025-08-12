@extends('layouts.auth')

@section('title', $title)

@section('content')
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Using Your registered email</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Password-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        {{-- <!--begin::Link-->
                        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                        <!--end::Link--> --}}
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign In</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->
    </div>
    <!--end::Body-->
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('assets/media/logos/side-lb.png') }})">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            {{-- <a href="index.html" class="mb-0 mb-lg-12">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" class="h-60px h-lg-75px" />
            </a> --}}
            <!--end::Logo-->
            <!--begin::Image-->
            <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px" style="position: relative; top:-15.5rem;" src="{{ asset('assets/media/logos/logo.png') }}" alt="" />
            <!--end::Image-->
            <!--begin::Title-->
            <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>
            <!--end::Title-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
@endsection