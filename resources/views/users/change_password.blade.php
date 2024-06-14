@php
    $html_tag_data = [];
    $title = 'Change Password';
    $description= ''
@endphp
@extends('layout',[
'html_tag_data'=>$html_tag_data,
'title'=>$title,
'description'=>$description
])

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/vendor/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/vendor/select2-bootstrap4.min.css') }}"/>
@endsection

@section('js_vendor')
    <script src="{{ asset('/js/vendor/select2.full.min.js') }}"></script>
@endsection

@section('js_page')
    <script src="{{ asset('/js/pages/settings.general.js') }}"></script>
@endsection


@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-auto mb-3 mb-md-0 me-auto">
                    <div class="w-auto sw-md-50">
                        <a href="#" class="muted-link pb-1 d-inline-block breadcrumb-back">
                            <i data-cs-icon="chevron-left" data-cs-size="13"></i>
                            <span class="text-small align-middle">Home</span>
                        </a>
                        <h1 class="mb-0 pb-0 display-4" id="title">{{ $title }}</h1>
                    </div>
                </div>
                <!-- Title End -->

                <!-- Top Buttons Start -->
                {{--                <div class="col-3 d-flex align-items-end justify-content-end">--}}
                {{--                    <!-- Check Button Start -->--}}
                {{--                    <div class="btn-group ms-1 check-all-container">--}}
                {{--                        <div class="btn btn-outline-primary btn-custom-control p-0 ps-3 pe-2" data-target="#checkboxTable">--}}
                {{--            <span class="form-check float-end">--}}
                {{--              <input type="checkbox" class="form-check-input" id="checkAll" />--}}
                {{--            </span>--}}
                {{--                        </div>--}}
                {{--                        <button--}}
                {{--                            type="button"--}}
                {{--                            class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"--}}
                {{--                            data-bs-offset="0,3"--}}
                {{--                            data-bs-toggle="dropdown"--}}
                {{--                            aria-haspopup="true"--}}
                {{--                            aria-expanded="false"--}}
                {{--                        ></button>--}}
                {{--                        <div class="dropdown-menu dropdown-menu-end">--}}
                {{--                            <a class="dropdown-item" href="#">--}}
                {{--                                <span class="align-middle d-inline-block">Status</span>--}}
                {{--                            </a>--}}
                {{--                            <a class="dropdown-item" href="#">--}}
                {{--                                <span class="align-middle d-inline-block">Move</span>--}}
                {{--                            </a>--}}
                {{--                            <a class="dropdown-item" href="#">--}}
                {{--                                <span class="align-middle d-inline-block">Delete</span>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <!-- Check Button End -->--}}
                {{--                </div>--}}
                <!-- Top Buttons End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        {{--        <!-- Controls Start -->--}}
        {{--        <div class="row mb-2">--}}
        {{--            <!-- Search Start -->--}}
        {{--            <div class="col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1">--}}
        {{--                <div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">--}}
        {{--                    <input class="form-control" placeholder="Search" />--}}
        {{--                    <span class="search-magnifier-icon">--}}
        {{--          <i data-cs-icon="search"></i>--}}
        {{--        </span>--}}
        {{--                    <span class="search-delete-icon d-none">--}}
        {{--          <i data-cs-icon="close"></i>--}}
        {{--        </span>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <!-- Search End -->--}}

        {{--            <div class="col-sm-12 col-md-7 col-lg-9 col-xxl-10 text-end mb-1">--}}
        {{--                <div class="d-inline-block">--}}
        {{--                    <!-- Print Button Start -->--}}
        {{--                    <button--}}
        {{--                        class="btn btn-icon btn-icon-only btn-foreground-alternate shadow"--}}
        {{--                        data-bs-toggle="tooltip"--}}
        {{--                        data-bs-placement="top"--}}
        {{--                        data-bs-delay="0"--}}
        {{--                        title="Print"--}}
        {{--                        type="button"--}}
        {{--                    >--}}
        {{--                        <i data-cs-icon="print"></i>--}}
        {{--                    </button>--}}
        {{--                    <!-- Print Button End -->--}}

        {{--                    <!-- Export Dropdown Start -->--}}
        {{--                    <div class="d-inline-block">--}}
        {{--                        <button class="btn p-0" data-bs-toggle="dropdown" type="button" data-bs-offset="0,3">--}}
        {{--            <span--}}
        {{--                class="btn btn-icon btn-icon-only btn-foreground-alternate shadow dropdown"--}}
        {{--                data-bs-delay="0"--}}
        {{--                data-bs-placement="top"--}}
        {{--                data-bs-toggle="tooltip"--}}
        {{--                title="Export"--}}
        {{--            >--}}
        {{--              <i data-cs-icon="download"></i>--}}
        {{--            </span>--}}
        {{--                        </button>--}}
        {{--                        <div class="dropdown-menu shadow dropdown-menu-end">--}}
        {{--                            <button class="dropdown-item export-copy" type="button">Copy</button>--}}
        {{--                            <button class="dropdown-item export-excel" type="button">Excel</button>--}}
        {{--                            <button class="dropdown-item export-cvs" type="button">Cvs</button>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <!-- Export Dropdown End -->--}}

        {{--                    <!-- Length Start -->--}}
        {{--                    <div class="dropdown-as-select d-inline-block" data-childSelector="span">--}}
        {{--                        <button class="btn p-0 shadow" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-offset="0,3">--}}
        {{--            <span--}}
        {{--                class="btn btn-foreground-alternate dropdown-toggle"--}}
        {{--                data-bs-toggle="tooltip"--}}
        {{--                data-bs-placement="top"--}}
        {{--                data-bs-delay="0"--}}
        {{--                title="Item Count"--}}
        {{--            >--}}
        {{--              10 Items--}}
        {{--            </span>--}}
        {{--                        </button>--}}
        {{--                        <div class="dropdown-menu shadow dropdown-menu-end">--}}
        {{--                            <a class="dropdown-item" href="#">5 Items</a>--}}
        {{--                            <a class="dropdown-item active" href="#">10 Items</a>--}}
        {{--                            <a class="dropdown-item" href="#">20 Items</a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <!-- Length End -->--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <!-- Controls End -->

        <!-- Order List Start -->
        <div class="row">
            <div class="col-12 mb-5">
                <section class="scroll-section" id="address">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{--                    {{ dd($decryptedPassword) }}--}}
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ url('/users/change_password_store') }}/{{ $user_data->id }}">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $user_data->id }}">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Old Password <span class="required">*</span></label>
                                            <input type="password" name="old_password" autocomplete="off" class="form-control" placeholder="Enter Old Password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">New Password <span class="required">*</span></label>
                                            <input type="password" name="new_password" autocomplete="off" class="form-control" placeholder="Enter New Password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password <span class="required">*</span></label>
                                            <input type="password" name="new_password_confirmation" autocomplete="off" class="form-control" placeholder="Enter Confirm Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="submit">
                                        <span>Change Password</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-edit-square undefined"><path d="M11 2L5.5 2C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5L2 14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 11"></path><path d="M15.4978 3.06224C15.7795 2.78052 16.1616 2.62225 16.56 2.62225C16.9585 2.62225 17.3405 2.78052 17.6223 3.06224C17.904 3.34396 18.0623 3.72605 18.0623 4.12446C18.0623 4.52288 17.904 4.90497 17.6223 5.18669L10.8949 11.9141L8.06226 12.6223L8.7704 9.78966L15.4978 3.06224Z"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('users') }}">
                                        <span>Back</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-left"><path d="M13 16L7.35355 10.3536C7.15829 10.1583 7.15829 9.84171 7.35355 9.64645L13 4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <!-- Order List End -->


    </div>
@endsection
