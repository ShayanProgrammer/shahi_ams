@php
    $html_tag_data = [];
    $title = 'Bank Account';
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
{{--                    <div class="btn-group ms-1 check-all-container">--}}

                        <a href="{{ route('banks') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Bank List</span>
                        </a>
{{--                    </div>--}}
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
                    url: '{{ route('bank_account_list') }}',
                    method: 'POST',
                    data: {
                        bank_id: '{{ Request::segment(3) }}'
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.bank_accounts;
                        var total_debit = 0;
                        var total_credit = 0;
                        var total_amount = 0;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        var table = $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',

                            data: _data,
                            aaSorting: [[ 0, "asc" ]],
                            columns: [
                                {data: 'created_at', title: 'Date'},
                                {
                                    title: 'Payment From',
                                    render: function (data, type, full, meta) {

                                        var import_duty_id = full['import_duty_id'];
                                        var customer_bill_id = full['customer_bill_id'];
                                        var customer_payment_id = full['customer_payment_id'];
                                        var text = '';

                                        if(import_duty_id != null) {
                                            text = "Import Duty";
                                        } else if(customer_bill_id != null) {
                                            text = "Customer Bill";
                                        } else if(customer_payment_id != null) {
                                            text = "Customer Payment";
                                        }

                                        return text;
                                    }
                                },
                                {
                                    title: 'Payment Detail',
                                    render: function (data, type, full, meta) {

                                        var import_duty_id = full['import_duty_id'];
                                        var customer_bill_id = full['customer_bill_id'];
                                        var customer_payment_id = full['customer_payment_id'];
                                        var text = '';

                                        if(import_duty_id != null) {
                                            text = "Performa No: "+full['import_duty_performa'];
                                        } else if(customer_bill_id != null) {
                                            text = "Bill No: "+full['invoice_number'];
                                        } else if(customer_payment_id != null) {
                                            text = "Customer Name: "+full['customer_name'];
                                        }

                                        return text;
                                    }
                                },
                                {data: 'debit', title: 'Debit'},
                                {data: 'credit', title: 'Credit'},
                                {
                                    title: 'Total',
                                    render: function (data, type, full, meta) {
                                        // var total_debit = 0;
                                        total_debit += full['debit'];
                                        total_credit += full['credit'];

                                        total_amount = total_debit - total_credit;

                                        if(total_amount < 0){
                                            total_amount = "(" + (-1 * total_amount) + ")";
                                        }
                                        return total_amount;
                                    }
                                },
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        {{--var edit_btn = '<a href="{{ url('bank_account_edit/') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';--}}
                                        var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';
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
                                    title: 'Bank Accounts'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'PDF',
                                    title: 'Bank Accounts'
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
                        $.ajax({
                            url: "{{ url('bank_account_delete') }}/{{ Request::segment(2) }}",
                            data: {
                                id: id
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
