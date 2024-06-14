@php
    $html_tag_data = [];
    $title = 'Shipping Arrival Setup';
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

                        <a href="{{ route('create_shipping_arrival') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Shipping Arrival</span>
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
        <div class="modal"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{--                    <div class="modal-header">--}}
                    {{--                        <h5 class="modal-title">Modal title</h5>--}}
                    {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--                            <span aria-hidden="true">&times;</span>--}}
                    {{--                        </button>--}}
                    {{--                    </div>--}}
                    <div class="modal-body">
                        <h1>Shipping Arrival Detail</h1>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Container Number</th>
                                <th>Arrived?</th>
                            </tr>
                            </thead>
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
                fetchList();
            });
            function fetchList(){

                $.ajax({
                    url: '{{ route('shipping_arrival_list') }}',
                    method: 'POST',
                    data: $("#filter-form").serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.shipping_arrivals;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'arrival_date', title: 'Arrival Date'},
                                {data: 'company_name', title: 'Company'},
                                {data: 'bl_tracking', title: 'BL Tracking'},
                                {data: 'port_name', title: 'Port Name'},
                                {data: 'performa', title: 'Performa'},
                                {data: 'no_of_container', title: 'No of Container'},
                                {data: 'item_description', title: 'Item Description'},
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var view_btn = '<a data-toggle="modal" data-target="#myModal" data-id="'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 view_detail_btn">View Detail</a>';
                                        var edit_btn = '<a href="{{ url('shipping_arrivals/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';
                                        var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';
                                        return view_btn + " " + edit_btn + " " +delete_btn;
                                    }
                                }
                            ],
                            dom: 'Blrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':not(:last-child)' // Exclude the last column (Action column)
                                    },
                                    text: 'Excel',
                                    title: 'Shipping Arrivals'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: ':not(:last-child)' // Exclude the last column (Action column)
                                    },
                                    text: 'PDF',
                                    title: 'Shipping Arrivals'
                                }
                                ]

                        })

                    }
                })
            }

            $(document).on('click','.view_detail_btn',function(){
                var shipping_arrival_id = $(this).data('id');

                $.ajax({

                    url: "{{ url('shipping_arrival_detail/view') }}",
                    method: 'POST',
                    data: {
                        shipping_arrival_id:shipping_arrival_id
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        var parsed = JSON.parse(result);

                        var html = '';
                        $.each(parsed.shipping_arrival_detail, function(k, v) {

                            html += '<tr>';
                            html += '<td>' + v.container_number + '</td>';
                            html += '<td><input type="checkbox" id="is_arrived" data-id="'+v.id+'"></td>';
                            html += '</tr>';
                        });

                        $('.table_body').html(html);

                        console.log(parsed);
                    }

                })
                // alert(shipping_arrival_id);
            })

            $(document).on('change','#is_arrived',function(){
                var id = $(this).data('id');
                var is_arrived = $(this).prop('checked');
                console.log(id);
                console.log(is_arrived);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Arrived!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        $.ajax({
                            url: "{{ route('update_shipping_arrival_arrived') }}",
                            data: {
                                id: id,
                                is_arrived: is_arrived
                            },
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            dataType: 'json',
                            success: function(result){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Changed',
                                    text: "Arrival Status Changed Successfully",
                                })
                            }
                        })
                    }
                })
            })

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
                            url: "{{ route('delete_shipping_arrival') }}",
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
