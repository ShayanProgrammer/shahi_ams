@php
    $html_tag_data = [];
    $title = 'Users Daily Activity';
    $description= ''
@endphp
@extends('layout',[
'html_tag_data'=>$html_tag_data,
'title'=>$title,
'description'=>$description
])

{{--@section('css')--}}

{{--@endsection--}}

{{--@section('js_vendor')--}}
{{--@endsection--}}

{{--@section('js_page')--}}
{{--    <script src="{{ asset('/js/cs/checkall.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/pages/orders.list.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/pages/discount.js') }}"></script>--}}
{{--@endsection--}}

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

                <!-- Top Buttons Start -->
                <div class="col-3 d-flex align-items-end justify-content-end">
                    <!-- Check Button Start -->
                    <div class="btn-group ms-1 check-all-container">

                        <select name="module" id="module_id" data-placeholder="Select Module Here" >
                            <option value="" disabled selected>Select Module Here</option>
                            <option value="companies" data-table="Company">Company</option>
                            <option value="account_payments" data-table="AccountPayment">Company Account Payment</option>
                            <option value="import_statuses" data-table="ImportStatus">Import Status</option>
                            <option value="packing_lists" data-table="PackingList">Packing List</option>
                            <option value="shipping_arrivals" data-table="ShippingArrival">Shipping Arrival</option>
                            <option value="clearing_agents" data-table="ClearingAgent">Clearing Agent</option>
                            <option value="clearing_agent_accounts" data-table="ClearingAgentAccount">Clearing Agent Payment</option>
                            <option value="warehouses" data-table="Warehouse">Warehouse</option>
                            <option value="stock_lists" data-table="StockList">Stock List</option>
                            <option value="packet_lists" data-table="PacketList">Packet List</option>
                            <option value="customers" data-table="Customer">Customer</option>
                            <option value="customer_payments" data-table="CustomerPayment">Customer Payment</option>
                            <option value="customer_bills" data-table="CustomerBill">Customer Bill</option>
                            <option value="banks" data-table="Bank">Bank</option>
                            <option value="import_duties" data-table="ImportDuties">Import Duties</option>
                            <option value="expenses" data-table="Expense">Expense</option>
                        </select>
                    </div>
                    <!-- Check Button End -->
                </div>
                <!-- Top Buttons End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Order List Start -->
{{--        <div class="row">--}}
{{--            <div class="col-12 mb-5">--}}
{{--                <section class="scroll-section" id="basic">--}}
{{--                    <div class="card mb-5">--}}
{{--                        <div class="card-body" >--}}
{{--                            <form class="form-inline" method="post" id="filter-form">--}}
{{--                                @csrf--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">From Date <span class="required">*</span></label>--}}
{{--                                    <input name="from_date" id="from_date" type="text" autocomplete="off" class="form-control date-picker-close">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">To Date <span class="required">*</span></label>--}}
{{--                                    <input name="to_date" id="to_date" type="text" autocomplete="off" class="form-control date-picker-close">--}}
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
                            <table class="table table-bordered table-hover table-striped" id="ajax_table">
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal"  id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h1>Change Status</h1>
                        <form id="">
                            <input type="hidden" value="" id="change_status_id">
                            <select class="form-control select-single-no-search" style="width:100%" name="change_status" id="change_status">
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_change" data-table="">Change</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h1>View Detail</h1>
                        <table class="table table-striped table-bordered">
                            <thead class="table_head"></thead>
                            <tbody class="table_body"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#module_id').change(function () {
                    fetchList($(this).val(),$(this).find('option:selected').text());
                    var selectedDataTable = $(this).find('option:selected').data('table');
                    var selectedValue = $(this).val();
                    $('#close_change').attr('data-table', selectedDataTable);

                    var html = '';
                    html += '<tr>';
                    if(selectedValue == 'companies') {
                        html += '<td>Name</td>';
                    } else if(selectedValue == 'account_payments') {
                        html += '<td>Company</td>';
                        html += '<td>Description</td>';
                        html += '<td>Total</td>';
                    } else if(selectedValue == 'import_statuses') {
                        html += '<td>Rate</td>';
                        html += '<td>Length</td>';
                        html += '<td>Size</td>';
                        html += '<td>Quantity</td>';
                        html += '<td>Total</td>';
                    } else if(selectedValue == 'packing_lists') {
                        html += '<td>Company</td>';
                        html += '<td>Container Number</td>';
                        html += '<td>File</td>';
                    } else if(selectedValue == 'shipping_arrivals') {
                        html += '<td>Company</td>';
                        html += '<td>Container Number</td>';
                    } else if(selectedValue == 'clearing_agents') {
                        html += '<td>Name</td>';
                    } else if(selectedValue == 'clearing_agent_accounts') {
                        html += '<td>Clearing Agent</td>';
                        html += '<td>BL No</td>';
                        html += '<td>Bill No</td>';
                        html += '<td>No of Container</td>';
                        html += '<td>Description</td>';
                        html += '<td>Date</td>';
                        html += '<td>Debit</td>';
                        html += '<td>Credit</td>';
                    } else if(selectedValue == 'warehouses') {
                        html += '<td>Name</td>';
                    } else if(selectedValue == 'stock_lists') {
                        html += '<td>Container Number</td>';
                        html += '<td>Date</td>';
                        html += '<td>No of Packets</td>';
                        html += '<td>Warehouse</td>';
                        html += '<td>Company</td>';
                    } else if(selectedValue == 'packet_lists') {
                        html += '<td>Warehouse</td>';
                        html += '<td>Container Number</td>';
                        html += '<td>Size</td>';
                    } else if(selectedValue == 'customers') {
                        html += '<td>Name</td>';
                    } else if(selectedValue == 'customer_payments') {
                        html += '<td>Customer</td>';
                        html += '<td>Amount</td>';
                        html += '<td>Payment Type</td>';
                        html += '<td>Cheque No</td>';
                        html += '<td>Bank Name</td>';
                    } else if(selectedValue == 'customer_bills') {
                        html += '<td>Customer</td>';
                        html += '<td>Warehouse</td>';
                        html += '<td>Container Number</td>';
                        html += '<td>Description</td>';
                        html += '<td>Size</td>';
                        html += '<td>Length</td>';
                        html += '<td>Rate</td>';
                        html += '<td>Quantity</td>';
                    } else if(selectedValue == 'banks') {
                        html += '<td>Bank</td>';
                    } else if(selectedValue == 'import_duties') {
                        html += '<td>Bank</td>';
                        html += '<td>Check</td>';
                        html += '<td>Payorder</td>';
                        html += '<td>Performa</td>';
                        html += '<td>Date</td>';
                        html += '<td>Amount</td>';
                        html += '<td>No of Container</td>';
                    } else if(selectedValue == 'expenses') {
                        html += '<td>Amount</td>';
                        html += '<td>Date</td>';
                    }
                    html += '</tr>';
                    $('.table_head').html(html);
                    //alert(selectedValue);
                })
            });
            function fetchList(module_name,text){

                module_name = $('#module_id').val();

                $.ajax({
                    url: '{{ route('right_list') }}',
                    method: 'POST',
                    data: {
                        module_name:module_name
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.response;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        var dataTable = $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'updated_at', title: 'Date'},
                                {
                                    title: 'Name',
                                    render: function (data, type, full, meta) {
                                        var detail = "";

                                        if(typeof full['name'] !== 'undefined') {
                                            detail = "Name: "+full['name'];
                                        } else if(typeof full['performa'] !== 'undefined') {
                                            detail = "Performa: "+full['performa'];
                                        } else if(typeof full['description'] !== 'undefined') {
                                            detail = "Description: "+full['description'];
                                        } else if(typeof full['bl_tracking'] !== 'undefined') {
                                            detail = "BL Tracking: "+full['bl_tracking'];
                                        } else if(typeof full['port_name'] !== 'undefined') {
                                            detail = "Port Name: "+full['port_name'];
                                        } else if(typeof full['container_number'] !== 'undefined') {
                                            detail = "Container No: "+full['container_number'];
                                        } else if(typeof full['amount'] !== 'undefined') {
                                            detail = "Amount: "+full['amount'];
                                        } else if(typeof full['invoice_number'] !== 'undefined') {
                                            detail = "Invoice Number: "+full['invoice_number']+", Total: "+full['total'];
                                        }
                                        return detail;
                                    }
                                },
                                {
                                    title: 'View Detail',
                                    render: function (data, type, full, meta) {
                                        var detail = "";
                                        detail = '<a data-toggle="modal" data-target="#myModal" data-id="'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 view_detail_btn">View Detail</a>';
                                        return detail;
                                    }
                                },
                                {data: 'added_by', title: 'Created By'},
                                {data: 'action', title: 'Action'},
                                {
                                    title: 'Status',
                                    render: function (data, type, full, meta) {
                                        var status = "";

                                        status += '<a data-toggle="modal" data-target="#changeStatus" data-id="'+full['id']+'" data-status-id="'+full['status_id']+'" id="status_changer">';

                                        if(full['status_id'] == 1) {
                                            status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-success text-uppercase status_check">'+full['status']+'</span></div>';
                                        } else if(full['status_id'] == 2) {
                                            status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-warning text-uppercase status_check">'+full['status']+'</span></div>';
                                        } else {
                                            status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-danger text-uppercase status_check">'+full['status']+'</span></div>';
                                        }

                                        status += '</a>';

                                        return status;

                                    }
                                }
                            ],
                            dom: 'Blrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'Excel',
                                    title: 'Expense'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'PDF',
                                    title: 'Expense'
                                }
                            ],
                            stateSave: true,

                        })

                        var selectedValue = text+ " Detail";
                        var columnIndex = 1
                        dataTable.column(columnIndex).header().innerHTML = selectedValue;

                    }
                })
            }

            $(document).on('click','.view_detail_btn',function(){
                var id = $(this).data('id');
                var table = $('#module_id').val();
                $.ajax({

                    url: "{{ url('general_view_detail') }}",
                    method: 'POST',
                    data: {
                        id:id,
                        table:table
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        var parsed = JSON.parse(result);
                        var detail = parsed.detail;

                        // alert("Table" + table);
                        console.log(detail);
                        var html = '';



                        $.each(detail, function(k, v) {
                            html += '<tr>';
                            if(table == 'companies') {
                                html += '<td>' + v.name + '</td>';
                            } else if(table == 'account_payments') {
                                html += '<td>' + v.company_name + '</td>';
                                html += '<td>' + v.description + '</td>';
                                html += '<td>' + v.total + '</td>';
                            } else if(table == 'import_statuses') {
                                html += '<td>' + v.rate + '</td>';
                                html += '<td>' + v.length + '</td>';
                                html += '<td>' + v.size + '</td>';
                                html += '<td>' + v.quantity + '</td>';
                                html += '<td>' + v.quantity * v.rate + '</td>';
                            } else if(table == 'packing_lists') {
                                html += '<td>' + v.company_name + '</td>';
                                html += '<td>' + v.container_number + '</td>';
                                html += '<td><a class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1" target="_blank" href="{{ asset('uploads/packing_list') }}'+'/'+ v.file_path + '">Download File</a></td>';
                            } else if(table == 'shipping_arrivals') {
                                html += '<td>' + v.company_name + '</td>';
                                html += '<td>' + v.container_number + '</td>';
                            } else if(table == 'clearing_agents') {
                                html += '<td>' + v.name + '</td>';
                            } else if(table == 'clearing_agent_accounts') {
                                html += '<td>' + v.clearing_agent_name + '</td>';
                                html += '<td>' + v.bl_no + '</td>';
                                html += '<td>' + v.bill_no + '</td>';
                                html += '<td>' + v.no_of_container + '</td>';
                                html += '<td>' + v.description + '</td>';
                                html += '<td>' + v.date + '</td>';
                                html += '<td>' + v.debit + '</td>';
                                html += '<td>' + v.credit + '</td>';
                            } else if(table == 'warehouses') {
                                html += '<td>' + v.name + '</td>';
                            } else if(table == 'stock_lists') {
                                html += '<td>' + v.container_number + '</td>';
                                html += '<td>' + v.date + '</td>';
                                html += '<td>' + v.no_of_packets + '</td>';
                                html += '<td>' + v.warehouse_name + '</td>';
                                html += '<td>' + v.company_name + '</td>';
                            } else if(table == 'packet_lists') {
                                html += '<td>' + v.warehouses_name + '</td>';
                                html += '<td>' + v.stock_container_number + '</td>';
                                html += '<td>' + v.size + '</td>';
                            } else if(table == 'customers') {
                                html += '<td>' + v.name + '</td>';
                            } else if(table == 'customer_payments') {
                                html += '<td>' + v.customer_name + '</td>';
                                html += '<td>' + v.amount + '</td>';
                                html += '<td>' + v.payment_type_name + '</td>';
                                html += '<td>' + v.cheque_no + '</td>';
                                html += '<td>' + v.bank_name + '</td>';
                            } else if(table == 'customer_bills') {
                                html += '<td>' + v.customer_name + '</td>';
                                html += '<td>' + v.warehouse_name + '</td>';
                                html += '<td>' + v.stock_container_number + '</td>';
                                html += '<td>' + v.packet_list_description + '</td>';
                                html += '<td>' + v.size + '</td>';
                                html += '<td>' + v.length + '</td>';
                                html += '<td>' + v.rate + '</td>';
                                html += '<td>' + v.quantity + '</td>';
                            } else if(table == 'banks') {
                                html += '<td>' + v.name + '</td>';
                            } else if(table == 'import_duties') {
                                html += '<td>' + v.bank_name + '</td>';
                                html += '<td>' + v.check + '</td>';
                                html += '<td>' + v.payorder + '</td>';
                                html += '<td>' + v.performa + '</td>';
                                html += '<td>' + v.date + '</td>';
                                html += '<td>' + v.amount + '</td>';
                                html += '<td>' + v.no_of_container + '</td>';
                            } else if(table == 'expenses') {
                                html += '<td>' + v.amount + '</td>';
                                html += '<td>' + v.date + '</td>';
                            }
                            html += '</tr>';
                        });



                        $('.table_body').html(html);
                    }
                })
            })


            $(document).ready(function(){
                $('#search_btn').click(function (){
                    fetchList($('#module_id').val(),$('#module_id').find('option:selected').text());
                })
                $('#reset_btn').click(function (){
                    $('#from_date').val('');
                    $('#to_date').val('');
                    fetchList($('#module_id').val(),$('#module_id').find('option:selected').text());
                })
            })

            $(document).ready(function() {
                $('#module_id').select2({
                    placeholder: "Select Module Name",
                });
            });

            $(document).on('click','#status_changer',function(){
                var id = $(this).data('id');
                var status_id = $(this).data('status-id');

                $.ajax({

                    url: "{{ url('get_all_status') }}",
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        var parsed = JSON.parse(result);

                        var html = '';
                        $.each(parsed.status, function(k, v) {
                            html += '<option value="'+v.id+'"';

                            // Check if the current option's value matches status_id and set 'selected' if it does.
                            if (v.id == status_id) {
                                html += ' selected';
                            }

                            html += '>'+v.status+'</option>';
                        });

                        $('#change_status').html(html);
                        $('#change_status_id').val(id);

                        console.log(parsed);
                    }

                })
                // alert(shipping_arrival_id);
            })

            $(document).on('click','#close_change',function(){
                var id = $("#change_status_id").val();
                var status_id = $("#change_status").val();
                // var table = $('#close_change').data('table');
                var table = $('#module_id').find('option:selected').data('table');
                console.log(table);
                $.ajax({
                    url: "{{ url('change_status') }}",
                    method: 'POST',
                    data: {
                        id:id,
                        status_id:status_id,
                        table:table
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        fetchList($('#module_id').val(),$('#module_id').find('option:selected').text());
                    }
                })
            })

        </script>
        <!-- Order List End -->
    </div>
@endsection
