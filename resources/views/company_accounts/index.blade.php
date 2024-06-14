@php
    $html_tag_data = [];
    $title = 'Company Account Setup';
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

                        <a href="{{ url('companies') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Company List</span>
                        </a>
                        <a href="{{ url('accountpayments/create') }}/{{ request()->segment(2) }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Company Account</span>
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
                            <h1>Company: <b>{{ $company->name }}</b></h1>
                            <br>
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
                    url: '{{ route('company_account_list') }}',
                    method: 'POST',
                    data: {
                        company: '{{ Request::segment(2) }}'
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.company_accounts;
                        var role_id = "{{ auth()->user()->role_id }}";

                        console.log(_data);

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "asc" ]],
                            columns: [
                                {data: 'created_at', title: 'Date'},
                                {
                                    title: 'Total',
                                    render: function (data, type, full, meta) {
                                        var value = '';
                                        if(full['total'] != null ){
                                            value = String(full['total']);
                                            value = value.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
                                        }
                                        return value;
                                    }
                                },
                                {data: 'description', title: 'Description'},
                                {
                                    title: 'Payment',
                                    render: function (data, type, full, meta) {
                                        var value = '';
                                        if(full['payment'] != null ){
                                            value = String(full['payment']);
                                            value = value.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
                                        }
                                        return value;
                                    }
                                },
                                {
                                    title: 'Adjusted Value',
                                    render: function (data, type, full, meta) {
                                        var value = '';
                                        if(full['value'] != null ){
                                            value = String(full['value']);
                                            value = value.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
                                        }
                                        return value;
                                    }
                                },
                                // {
                                //     title: 'Accounts Payable',
                                //     render: function (data, type, full, meta) {
                                //         var value = '';
                                //         if(full['payable'] != null){
                                //             value = String(full['payable']);
                                //             value = value.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
                                //         }
                                //         return value;
                                //     }
                                // },
                                // {
                                //     title: 'Accounts Receivable',
                                //     render: function (data, type, full, meta) {
                                //         var value = '';
                                //         if(full['receivable'] != null){
                                //
                                //             console.log(String(full['receivable']));
                                //             value = String(full['receivable']);
                                //             value = value.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
                                //             console.log(value);
                                //         }
                                //         return value;
                                //     }
                                // },
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var delete_btn = "";
                                        if(role_id == 1) {
                                            var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" data-payment="'+full['payment']+'" data-company-id="'+full['company_id']+'" data-account-id="'+full['account_payment_id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';
                                        }

                                        return delete_btn;
                                    }
                                }
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

            $(document).on('click','#delete_data',function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        var account_id = $(this).data('account-id');
                        var payment = $(this).data('payment');
                        var company_id = $(this).data('company-id');
                        $.ajax({
                            url: "{{ route('delete_company_account') }}",
                            data: {
                                id: id,
                                account_id: account_id,
                                payment: payment,
                                company_id: company_id,
                            },
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            dataType: 'json',
                            success: function(result){
                                console.log(result);
                                fetchList();
                                $("#eq-loader").hide();
                                if (result.HasError == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: result.message,
                                    })
                                }
                                else{
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Operation Performed',
                                        text: result.message,
                                    })
                                }
                            }
                        })

                    }
                })
            })
        </script>
        <!-- Order List End -->
    </div>
@endsection
