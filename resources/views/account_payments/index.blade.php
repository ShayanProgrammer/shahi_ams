@php
    $html_tag_data = [];
    $title = 'Account Payments';
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
    {{-- <script src="{{ asset('/js/cs/checkall.js') }}"></script> --}}
    {{-- <script src="{{ asset('/js/pages/orders.list.js') }}"></script> --}}
@endsection

@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-auto mb-3 mb-md-0 me-auto">
                    <div class="w-auto sw-md-50">
                        <a href="{{ url('companies') }}" class="muted-link pb-1 d-inline-block breadcrumb-back">
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

                        <a href="{{ url('accountpayments/create') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Account Payment</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-plus undefined"><path d="M10 17 10 3M3 10 17 10"></path></svg>
                        </a>
                    </div>
                    <!-- Check Button End -->
                </div>
                <!-- Top Buttons End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Order List Start -->
        <div class="row">
            <div class="col-12 mb-5">
                <section class="scroll-section" id="basic">
                    <div class="card mb-5">
                        <div class="card-body">
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
                    url: "{{ url('accountpayments/list') }}",
                    method: 'POST',
                    data: $("#filter-form").serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        // console.log(data);
                        // return false;
                        var _data = data.account_payments;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'company_name', title: 'Company'},
                                {data: 'description', title: 'Description'},
                                {data: 'total', title: 'Payment'},
                                // {
                                //     title: 'Action',
                                //     render: function (data, type, full, meta) {
                                //         // var edit_btn = '<a href="#'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';

                                //         // var delete_btn = '<a href="#" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';

                                //         // var importstatuses_btn = '<a href="#" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Import Status</a>';

                                //         // var company_account_btn = '<a href="#" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Account</a>';

                                //         return '';
                                //     }
                                // }
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
        </script>
        <!-- Order List End -->
    </div>
@endsection
