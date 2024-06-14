@php
    $html_tag_data = [];
    $title = 'Stock Report';
    $description= ''
@endphp
@extends('layout',[
'html_tag_data'=>$html_tag_data,
'title'=>$title,
'description'=>$description
])

@section('css')
@endsection

@section('js_vendor')
@endsection

@section('js_page')
    <script src="{{ asset('/js/cs/checkall.js') }}"></script>
    <script src="{{ asset('/js/pages/orders.list.js') }}"></script>
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
                <div class="col-3 d-flex align-items-end justify-content-end">
                    <!-- Check Button Start -->
                    <div class="btn-group ms-1 check-all-container">

                    </div>
                    <!-- Check Button End -->
                </div>
                <!-- Top Buttons End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

{{--        <div class="row">--}}
{{--            <div class="col-12 mb-5">--}}
{{--                <section class="scroll-section" id="basic">--}}
{{--                    <div class="card mb-5">--}}
{{--                        <div class="card-body" >--}}
{{--                            <form class="form-inline" method="post" id="filter-form">--}}
{{--                                @csrf--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Company <span class="required">*</span></label>--}}
{{--                                    <select class="form-control company_id" name="company_id">--}}
{{--                                        <option value="">Select Company</option>--}}
{{--                                        @foreach($companies as $company)--}}
{{--                                            <option value="{{ $company->id }}">{{ $company->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Warehouse <span class="required">*</span></label>--}}
{{--                                    <select class="form-control warehouse_id" name="warehouse_id">--}}
{{--                                        <option value="">Select Company</option>--}}
{{--                                        @foreach($warehouses as $warehouse)--}}
{{--                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Container</label>--}}
{{--                                    <select class="form-control stocklist_id" name="stocklist_id">--}}
{{--                                        <option value="">Select Container</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Description <span class="required">*</span></label>--}}
{{--                                    <select class="form-control packetlist_id" name="packetlist_id">--}}
{{--                                        <option value="">Select Packet</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Size</label>--}}
{{--                                    <select class="form-control size_id" name="size_id">--}}
{{--                                        <option value="">Select Size</option>--}}
{{--                                        @foreach($sizes as $size)--}}
{{--                                            <option value="{{ $size->size }}">{{ $size->size }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <br>--}}
{{--                                <input type="button" value="Search" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1" id="search_btn">--}}
{{--                                <input type="button" value="Reset" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1" id="reset_btn">--}}
{{--                            </form>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row">
            <div class="col-12 mb-5">
                <section class="scroll-section" id="basic">
                    <div class="card mb-5">
                        <div class="card-body">
                            <form class="row g-3" method="post" id="filter-form">
                                @csrf
                                <div class="col-md-2">
                                    <label for="" class="form-label">Company</label>
                                    <select class="form-select company_id" name="company_id">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Warehouse</label>
                                    <select class="form-select warehouse_id" name="warehouse_id">
                                        <option value="">Select Warehouse</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Container</label>
                                    <select class="form-select stocklist_id" name="stocklist_id">
                                        <option value="">Select Container</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Description</label>
                                    <select class="form-select packetlist_id" name="packetlist_id">
                                        <option value="">Select Packet</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Size</label>
                                    <select class="form-select size_id" name="size_id">
                                        <option value="">Select Size</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->size }}">{{ $size->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-lg btn-outline-primary ms-1" id="search_btn">Search</button>
                                    <button type="button" class="btn btn-lg btn-outline-primary ms-1" id="reset_btn" style="margin: 4px; width: 112px;">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <style>
            .total-quantity {
                position: absolute;
                top: 15px;
                right: 30px;
                font-size: 20px;
            }
        </style>
        <!-- Order List Start -->
        <div class="row">
            <div class="col-12 mb-5">
                <section class="scroll-section" id="basic">
                    <div class="card mb-5">
                        <div class="card-body">
                            <strong id="totalQuantity" class="total-quantity"></strong>
                            <table class="table table-bordered table-hover table-striped" id="ajax_table">
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                fetchList();
            });
            function fetchList(){

                $.ajax({
                    url: '{{ route('stock_report_list') }}',
                    method: 'POST',
                    data: $("#filter-form").serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        // console.log(data);
                        // return false;
                        var _data = data.stock_reports;

                        // Calculate total quantity
                        let totalQuantity = _data.reduce((total, report) => total + parseFloat(report.quantity), 0);

                        // Display total quantity above the table
                        $('#totalQuantity').text('Total Quantity: ' + totalQuantity);


                        // console.log(_data);

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'company_name', title: 'Company'},
                                {data: 'warehouse_name', title: 'Warehouse'},
                                {data: 'container_number', title: 'Container'},
                                {data: 'description', title: 'Description'},
                                {data: 'size', title: 'Size'},
                                {data: 'length', title: 'Length'},
                                {data: 'quantity', title: 'Quantity'},
                            ],
                            dom: 'Blrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'Excel',
                                    title: 'Import Status'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'PDF',
                                    title: 'Import Status'
                                }
                            ]
                        })
                    }
                })
            }


            $(document).on('change','.warehouse_id, .company_id',function(){
                var warehouse_id = $('.warehouse_id').val();
                var company_id = $('.company_id').val();
                // alert('#'+row_id+' .col-md-2 .mb-3 .w-100 .stocklist_id');
                $.ajax({
                    url: '{{ route('get_stocklist_by_warehouse_and_company') }}',
                    data: {
                        warehouse_id: warehouse_id,
                        company_id: company_id,
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
                        $('.stocklist_id').html(html_stock);
                    }
                })
            })

            $(document).on('change','.stocklist_id',function(){
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
                        $('.packetlist_id').html(html_packet);
                    }
                })
            })

            $(document).ready(function(){
                $('#search_btn').click(function (){
                    fetchList();
                })
                $('#reset_btn').click(function (){
                    $(".company_id").val($(".company_id option:first").val());
                    $(".warehouse_id").val($(".warehouse_id option:first").val());
                    $(".stocklist_id").val($(".stocklist_id option:first").val());
                    $(".packetlist_id").val($(".packetlist_id option:first").val());
                    $(".size_id").val($(".size_id option:first").val());
                    fetchList();
                })

                // $('.size_id').click(function (){
                //     fetchList();
                // })
            })

        </script>
        <!-- Order List End -->
    </div>
@endsection
