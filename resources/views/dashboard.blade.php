﻿@php
    $html_tag_data = [];
    $title = 'Dashboard';
    $description= 'Ecommerce Dashboard'
@endphp
@extends('layout',[
'html_tag_data'=>$html_tag_data,
'title'=>$title,
'description'=>$description
])

@section('css')
@endsection

@section('js_vendor')
    <script src="{{ asset('/js/vendor/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/vendor/chartjs-plugin-rounded-bar.min.js') }}"></script>
    <script src="{{ asset('/js/vendor/jquery.barrating.min.js') }}"></script>
@endsection

@section('js_page')
    <script src="{{ asset('/js/cs/charts.extend.js') }}"></script>
    <script src="{{ asset('/js/pages/dashboard.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                    <a class="muted-link pb-2 d-inline-block hidden" href="#">
                        <span class="align-middle lh-1 text-small">&nbsp;</span>
                    </a>
                    <h1 class="mb-0 pb-0 display-4" id="title">Welcome, DABS!</h1>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->
{{--        {{ dd($user->role_id) }}--}}
        <!-- Stats Start -->
        <div class="row">
            <div class="col-12">
                <div class="mb-5">
                    <div class="row g-2">
                        @if($user->role_id != 3)
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <a href="{{ url('companies') }}">
                                <div class="card h-100 hover-scale-up cursor-pointer">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/company.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            COMPANY
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <a href="{{ url('importstatuses') }}">
                                <div class="card h-100 hover-scale-up cursor-pointer">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/import_status.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            IMPORT STATUS
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <a href="{{ url('packinglists') }}">
                                <div class="card h-100 hover-scale-up cursor-pointer">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/packing_list.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            PACKING LIST
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('shipping_arrivals') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/shipping_arrivals.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            SHIPPING ARRIVALS
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @if($user->role_id != 3)
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <div class="card h-100 hover-scale-up cursor-pointer">
                                    <a href="{{ url('clearing_agents') }}">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <img src="{{ asset('img/dashboard/clearing_agent.png') }}" width="200px" height="150px">
                                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                                CLEARING AGENTS
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif


                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('warehouses') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/warehouse.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            WAREHOUSE LIST
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('stocklists') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/stock.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            STOCK LIST
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('packetlists') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/packet_list.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            PACKET LIST
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
{{--                    </div>--}}
{{--                    <br>--}}
{{--                    <div class="row g-2">--}}
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('customers') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/customer.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            CUSTOMER
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        @if($user->role_id == 1)
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('banks') }}">
                                    <div class="card h-100 hover-scale-up cursor-pointer">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <img src="{{ asset('img/dashboard/bank.png') }}" width="200px" height="150px">
                                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                                BANK LIST
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('importduties') }}">
                                    <div class="card h-100 hover-scale-up cursor-pointer">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <img src="{{ asset('img/dashboard/import_duties.png') }}" width="200px" height="150px">
                                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                                IMPORT DUTIES
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if($user->role_id == 1)
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="card h-100 hover-scale-up cursor-pointer">
                                <a href="{{ url('expenses') }}">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <img src="{{ asset('img/dashboard/expense.png') }}" width="200px" height="150px">
                                        <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">
                                            EXPENSE
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
