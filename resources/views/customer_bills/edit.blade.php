@php
    $html_tag_data = [];
    $title = 'Customer Bill Update';
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
    <link rel="stylesheet" href="{{ asset('/css/vendor/bootstrap-datepicker3.standalone.min.css') }}"/>
@endsection

@section('js_vendor')
    <script src="{{ asset('/js/vendor/imask.js') }}"></script>
    <script src="{{ asset('/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/vendor/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/vendor/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
@endsection

@section('js_page')
    <script src="{{ asset('/js/pages/settings.general.js') }}"></script>
    <script src="{{ asset('/js/pages/discount.js') }}"></script>
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

            </div>
        </div>
        <!-- Title and Top Buttons End -->
{{--        @if(isset($customer_bill->cheque_no))--}}
{{--            {{ 'yes' }}--}}
{{--        @else--}}
{{--            {{ 'no' }}--}}
{{--        @endif--}}
{{--        {{ dd($customer_bill) }}--}}
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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ route('update_customer_bill') }}">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $customer_bill->id }}">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Bill Number <span class="required">*</span></label>
                                            <input type="text" name="bill_no" autocomplete="off" class="form-control" value="{{ $customer_bill->invoice_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Customer List <span class="required">*</span></label>
                                                <select class="select-single-no-search" name="customer_id">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" {{ $customer->id == $customer_bill->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input placeholder="Select Date" id="datePickerInputGroup" type="text" autocomplete="off" name="date" class="form-control date-picker-close date" value="{{ $customer_bill->date }}" autocomplete="off">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-calendar text-muted"><path d="M14.5 4C15.9045 4 16.6067 4 17.1111 4.33706C17.3295 4.48298 17.517 4.67048 17.6629 4.88886C18 5.39331 18 6.09554 18 7.5L18 14.5C18 15.9045 18 16.6067 17.6629 17.1111C17.517 17.3295 17.3295 17.517 17.1111 17.6629C16.6067 18 15.9045 18 14.5 18L5.5 18C4.09554 18 3.39331 18 2.88886 17.6629C2.67048 17.517 2.48298 17.3295 2.33706 17.1111C2 16.6067 2 15.9045 2 14.5L2 7.5C2 6.09554 2 5.39331 2.33706 4.88886C2.48298 4.67048 2.67048 4.48298 2.88886 4.33706C3.39331 4 4.09554 4 5.5 4L14.5 4Z"></path><path d="M2 9H18M7 2 7 5.5M13 2 13 5.5M5 15H6"></path></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Payment Type <span class="required">*</span></label>
                                                <select class="select-single-no-search" name="payment_type_id" id="payment_type_id">
                                                    <option value="" disabled>Select Payment Type</option>
                                                    @foreach($payment_types as $payment_type)
                                                        <option value="{{ $payment_type->id }}" {{ $payment_type->id == $customer_bill->payment_type_id ? 'selected' : '' }}>{{ $payment_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style='@if(isset($customer_bill->cheque_no)) {{ "display:block;" }} @else {{ "display:none;" }} @endif' id="cheque_no_div">
                                        <div class="mb-3">
                                            <label class="form-label">Cheque Number <span class="required">*</span></label>
                                            <input type="text" name="cheque_no" autocomplete="off" class="form-control" value="{{ $customer_bill->cheque_no }}" placeholder="Enter Cheque Number">
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="@if(isset($customer_bill->bank_id)) {{ "display:block;" }} @else {{ "display:none;" }} @endif" id="bank_div">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Bank <span class="required">*</span></label>
                                                <select class="select-single-no-search bank" name="bank" id="bank">
                                                    <option value="" disabled>Select Bank</option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank->id }}" {{ $bank->id == $customer_bill->bank_id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="col-md-4">--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <div class="w-100" data-select2-id="1">--}}
{{--                                                <label class="form-label">Warehouse List <span class="required">*</span></label>--}}
{{--                                                <select class="form-control" name="company_id">--}}
{{--                                                    <option value="">Select Warehouse</option>--}}
{{--                                                    @foreach($warehouses as $warehouse)--}}
{{--                                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == $customer_bill->warehouse_id ? 'selected' : '' }}>{{ $warehouse->name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <div class="w-100" data-select2-id="1">--}}
{{--                                                <label class="form-label">Stock List <span class="required">*</span></label>--}}
{{--                                                <select class="form-control" name="company_id">--}}
{{--                                                    <option value="">Select Stock List</option>--}}
{{--                                                    @foreach($stocklists as $stocklist)--}}
{{--                                                        <option value="{{ $stocklist->id }}" {{ $stocklist->id == $customer_bill->stocklist_id ? 'selected' : '' }}>{{ $stocklist->container_number }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <div class="w-100" data-select2-id="1">--}}
{{--                                                <label class="form-label">Packing List <span class="required">*</span></label>--}}
{{--                                                <select class="form-control" name="company_id">--}}
{{--                                                    <option value="">Select Packing Item</option>--}}
{{--                                                    @foreach($packetlists as $packetlist)--}}
{{--                                                        <option value="{{ $packetlist->id }}" {{ $packetlist->id == $customer_bill->packetlist_id ? 'selected' : '' }}>{{ $packetlist->description }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="row g-3">

                                    <div class="appendable_div" id="appendable_div">
                                        @php $count = 0; @endphp
                                        @if(empty($customer_bill_details))
                                            <div class="row g-3 repeatDiv" id="repeatDiv_0" style="margin-top:10px;">

                                                <input id="hidden_id" type="hidden" value="{{ $customer_bill_detail->id != null ? $customer_bill_detail->id : 0  }}" name="customer_bill_detail_id[]">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Warehouse List <span class="required">*</span></label>
                                                            <select class="form-control warehouse_id" name="warehouse_id[]">
                                                                <option value="">Select Warehouse</option>
                                                                @foreach($warehouses as $warehouse)
                                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Company<span class="required">*</span></label>
                                                            <select class="form-control company_id" name="company_id[]" id="company_id">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Stock List <span class="required">*</span></label>
                                                            <select class="form-control stocklist_id" name="stocklist_id[]" id="stocklist_id">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Packing List <span class="required">*</span></label>
                                                            <select class="form-control packetlist_id" name="packetlist_id[]" id="packetlist_0">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Size <span class="required">*</span></label>
                                                        <select class="form-control size_id" name="size_id[]" id="size_0">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <label class="form-label">Length <span class="required">*</span></label>
                                                        <select class="form-control length_id" name="length_id[]" id="length_0">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Rate <span class="required">*</span></label>
                                                            <input type="text" name="rate[]" autocomplete="off" class="form-control" id="rate_0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Quantity <span class="required">*</span></label>
                                                            <input type="text" name="quantity[]" autocomplete="off" class="form-control" id="quantity_0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $customer_bill_detail->id }}" data-customer_bill_id="{{ $customer_bill_detail->customer_bill_id }}" data-raw="@php echo $count; @endphp">X</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @foreach($customer_bill_details as $customer_bill_detail)

                                            <div class="row g-3 repeatDiv" id="repeatDiv@php if($count != 0){ echo "_".$count; } @endphp" style="margin-top:10px;">

                                                <input id="hidden_edit_id" type="hidden" value="{{ $customer_bill_detail->id != null ? $customer_bill_detail->id : 0  }}" name="customer_bill_detail_id[]">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Warehouse List <span class="required">*</span></label>
                                                            <select class="form-control warehouse_class warehouse_id_@php echo $count; @endphp" name="warehouse_id[]" id="warehouse_@php echo $count; @endphp">
                                                                <option value="">Select Warehouse</option>
                                                                @foreach($warehouses as $warehouse)
                                                                    <option value="{{ $warehouse->id }}" {{ $warehouse->id == $customer_bill_detail->warehouse_id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Stock List <span class="required">*</span></label>
                                                            <select class="form-control stocklist_class stocklist_id_@php echo $count; @endphp" name="stocklist_id[]" id="stocklist_@php echo $count; @endphp">
                                                                <option value="">Select Stock List</option>
                                                                @foreach($stocklists as $stocklist)
                                                                    <option value="{{ $stocklist->id }}" {{ $stocklist->id == $customer_bill_detail->stocklist_id ? 'selected' : '' }}>{{ $stocklist->container_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Packet List <span class="required">*</span></label>
                                                            <select class="form-control packetlist_class packetlist_id_@php echo $count; @endphp" name="packetlist_id[]" id="packetlist_@php echo $count; @endphp">
                                                                <option value="">Select Packing Item</option>
                                                                @foreach($packetlists as $packetlist)
                                                                    <option value="{{ $packetlist->id }}" {{ $packetlist->id == $customer_bill_detail->packetlist_id ? 'selected' : '' }}>{{ $packetlist->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Size <span class="required">*</span></label>
                                                            <select class="form-control size_class size_id_@php echo $count; @endphp" name="size_id[]" id="size_@php echo $count; @endphp">
                                                                <option value="">Select Size</option>
                                                                @foreach($packetlistdetails as $packetlistdetail)
                                                                    <option value="{{ $packetlistdetail->id }}" {{ $packetlistdetail->id == $customer_bill_detail->packetlist_detail_id ? 'selected' : '' }}>{{ $packetlistdetail->size }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100" data-select2-id="1">
                                                            <label class="form-label">Length <span class="required">*</span></label>
                                                            <select class="form-control length_class length_id_@php echo $count; @endphp" name="length_id[]" id="length_@php echo $count; @endphp">
                                                                <option value="">Select Length</option>
                                                                @foreach($lengths as $length)
                                                                    <option value="{{ $length->id }}" {{ $length->id == $customer_bill_detail->length_id ? 'selected' : '' }}>{{ $length->length }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Rate <span class="required">*</span></label>
                                                            <input type="text" name="rate[]" class="form-control rate_class" value="{{ $customer_bill_detail->rate }}" id="rate_@php echo $count; @endphp">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Quantity <span class="required">*</span></label>
                                                            <input type="text" name="quantity[]" class="form-control quantity_class" value="{{ $customer_bill_detail->quantity }}" id="quantity_@php echo $count; @endphp">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $customer_bill_detail->id }}" data-customer_bill_id="{{ $customer_bill_detail->customer_bill_id }}" data-raw="@php echo $count; @endphp">X</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @php $count++; @endphp
                                        @endforeach
                                        <div class="btn_div">
                                            <button type="button" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 mt-20" style="margin-top: 10px;" id="repeatDivBtn" data-increment="@php echo $count; @endphp">Add More</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="submit">
                                        <span>Update</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-edit-square undefined"><path d="M11 2L5.5 2C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5L2 14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 11"></path><path d="M15.4978 3.06224C15.7795 2.78052 16.1616 2.62225 16.56 2.62225C16.9585 2.62225 17.3405 2.78052 17.6223 3.06224C17.904 3.34396 18.0623 3.72605 18.0623 4.12446C18.0623 4.52288 17.904 4.90497 17.6223 5.18669L10.8949 11.9141L8.06226 12.6223L8.7704 9.78966L15.4978 3.06224Z"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('customer_bills') }}">
                                        <span>Back</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-left"><path d="M13 16L7.35355 10.3536C7.15829 10.1583 7.15829 9.84171 7.35355 9.64645L13 4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
{{--                <section class="scroll-section" id="basicSingle">--}}
{{--                    <h2 class="small-title">Basic Single</h2>--}}
{{--                    <div class="card mb-5">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row" data-select2-id="20">--}}
{{--                                <div class="col-12 col-sm-6 col-xl-4" data-select2-id="19">--}}
{{--                                    <div class="w-100" data-select2-id="1">--}}
{{--                                        <label class="form-label">City <span class="required">*</span></label>--}}
{{--                                        <select class="form-control">--}}
{{--                                            <option label="&nbsp;"></option>--}}
{{--                                            <option value="Tokyo" selected>Tokyo</option>--}}
{{--                                            <option value="...">...</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
            </div>
        </div>

        <!-- Order List End -->


    </div>
    <script>
        var $newid;

        $("#repeatDivBtn").click(function () {

            $newid = $(this).data("increment");

            $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
            // alert($repeatDiv);
            $('#repeatDiv').unwrap();
            $($repeatDiv).insertAfter($(".repeatDiv").last());
            $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid)
            $(".warehouse_class").last().attr('id',   "warehouse" + '_' + $newid)
            $(".stocklist_class").last().attr('id',   "stocklist" + '_' + $newid)
            $(".packetlist_class").last().attr('id',   "packetlist" + '_' + $newid)
            $(".size_class").last().attr('id',   "size" + '_' + $newid)
            $(".length_class").last().attr('id',   "length" + '_' + $newid)
            $(".rate_class").last().attr('id',   "rate" + '_' + $newid)
            $(".quantity_class").last().attr('id',   "quantity" + '_' + $newid)
            $(".remove_raw_btn").last().attr('data-raw', $newid)
            $(".remove_raw_btn").last().attr('data-id', '')
            $("#repeatDiv" + '_' + $newid).find('input').val('');
            $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
            $(".warehouse_class").last().val($('.warehouse_class option:first').val());
            $(".stocklist_class").last().val($('.stocklist_class option:first').val());
            $(".packetlist_class").last().val($('.packetlist_class option:first').val());
            $(".size_class").last().val($('.size_class option:first').val());
            $(".length_class").last().val($('.length_class option:first').val());
            $('.stocklist_class').last().empty();
            $('.packetlist_class').last().empty();
            $('.size_class').last().empty();
            $('.length_class').last().empty();
            $newid++;
            $(this).data("increment", $newid);
        });

        $(document).on('click', '.removeDivBtn', function () {
            $divId = $(this).data("id");
            $("#"+$divId).remove();
            $inc = $("#repeatDivBtn").data("increment");
            $("#repeatDivBtn").data("increment", $inc-1);
        });

        $(document).on('click', '.remove_raw_btn', function () {
            $divId = $(this).data("raw");
            if($divId == 0) {
                $('#hidden_edit_id').val('');
                $("#warehouse_0").val($("#warehouse_0 option:first").val());
                $("#stocklist_0").val($("#stocklist_0 option:first").val());
                $("#packetlist_0").val($("#packetlist_0 option:first").val());
                $("#size_0").val($("#size_0 option:first").val());
                $("#length_0").val($("#length_0 option:first").val());
                $('#rate_0').val('');
                $('#quantity_0').val('');
            } else {
                $("#repeatDiv_"+$divId).remove();
            }

            if($divId != '') {
                $id = $(this).data("id");
                $customer_bill_id = $(this).data("customer_bill_id");
                $.ajax({
                    url: "{{ route('remove_single_customer_bill') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: $id,
                        customer_bill_id: $customer_bill_id,
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });

        $(document).ready(function(){

            // $divId = $(this).data("raw");

            $(document).on('change','.warehouse_class',function(){
                var id = $(this).attr('id');
                var parts = id.split('_');
                var selectbox_name = parts[0];
                var row_number = parts[1];
                var warehouse_id = $(this).val();
                $.ajax({
                    url: '{{ route('get_stocklist_by_warehouse') }}',
                    data: {
                        warehouse_id: warehouse_id,
                    },
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    success: function(result){
                        var html_stock = '';
                        html_stock += '<option value="" selected>Select Container Number</option>';
                        $.each(result.stocklist, function(k, v) {
                            html_stock += '<option value='+v.id+'>'+v.container_number+'</option>';
                        });
                        $('#stocklist_'+row_number).html(html_stock);
                    }
                })
            })
            $(document).on('change','.stocklist_class',function(){
                var id = $(this).attr('id');
                var parts = id.split('_');
                var selectbox_name = parts[0];
                var row_number = parts[1];
                var stocklist_id = $(this).val();
                $.ajax({
                    url: '{{ route('get_packetlist_by_stocklist') }}',
                    data: {
                        stocklist_id: stocklist_id,
                    },
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    success: function(result){
                        var html_packet = '';
                        html_packet += '<option value="" selected>Select Packing Item</option>';
                        $.each(result.packetlist, function(k, v) {
                            html_packet += '<option value='+v.id+'>'+v.description+'</option>';
                        });
                        $('#packetlist_'+row_number).html(html_packet);
                    }
                })
            })
            $(document).on('change','.packetlist_class',function(){
                var id = $(this).attr('id');
                var parts = id.split('_');
                var selectbox_name = parts[0];
                var row_number = parts[1];
                var packetlist_id = $(this).val();
                $.ajax({
                    url: '{{ route('get_size_by_packetlist') }}',
                    data: {
                        packetlist_id: packetlist_id,
                    },
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    success: function(result){
                        var html_size = '';
                        html_size += '<option value="" selected>Select Size</option>';
                        $.each(result.packetlist_details, function(k, v) {
                            html_size += '<option value='+v.id+'>'+v.size+'</option>';
                        });
                        $('#size_'+row_number).html(html_size);
                    }
                })
            })

            $(document).on('change','.size_class',function(){
                var id = $(this).attr('id');
                var parts = id.split('_');
                var selectbox_name = parts[0];
                var row_number = parts[1];
                var size_id = $(this).val();
                $.ajax({
                    url: '{{ route('get_length_by_size') }}',
                    data: {
                        size_id: size_id,
                    },
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    success: function(result){
                        var html_length = '';
                        html_length += '<option value="" selected>Select Length</option>';
                        $.each(result.lengths, function(k, v) {
                            html_length += '<option value='+v.id+'>'+v.length+'</option>';
                        });
                        $('#length_'+row_number).html(html_length);
                    }
                })
            })

            $(document).ready(function () {
                // $('#cheque_no_div').hide();
                // $('#payment_type_id').change(function () {
                //     var selectedOption = $(this).val();
                //     if (selectedOption === '2') {
                //         $('#cheque_no_div').show();
                //     } else {
                //         $('#cheque_no_div').hide();
                //     }
                // });

                $('#payment_type_id').change(function () {
                    var selectedOption = $(this).val();
                    if (selectedOption == '2') {
                        $('#cheque_no_div').show();
                        $('#bank_div').hide();
                    } else if(selectedOption == '3') {
                        $('#cheque_no_div').show();
                        $('#bank_div').show();
                    } else if(selectedOption == '4') {
                        $('#bank_div').show();
                        $('#cheque_no_div').hide();
                    } else {
                        $('#bank_div').hide();
                        $('#cheque_no_div').hide();
                    }
                });
            });
        });

        $(document).ready(function() {
            // $('.warehouse_id').select2({
            //     placeholder: "Select Warehouse",
            // });
            // $('.stocklist_id').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.packetlist_id').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.size_id').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.length_id').select2({
            //     placeholder: "Select Stock List Container",
            // });
            //
            // $('.warehouse_class').select2({
            //     placeholder: "Select Warehouse",
            // });
            // $('.stocklist_class').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.packetlist_class').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.size_class').select2({
            //     placeholder: "Select Stock List Container",
            // });
            // $('.length_class').select2({
            //     placeholder: "Select Stock List Container",
            // });
        });

    </script>
@endsection
