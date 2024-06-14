@php
    $html_tag_data = [];
    $title = 'Stock List';
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
{{--    <script src="{{ asset('/js/cs/checkall.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/pages/orders.list.js') }}"></script>--}}
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

                        <a href="{{ route('create_stocklist') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Stock List</span>
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
                        <h1>Packet List Detail</h1>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Size</th>
                            </tr>
                            </thead>
                            <tbody class="table_body"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        {{--                        <button type="button" class="btn btn-primary">Save changes</button>--}}
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
                    url: '{{ url('stocklist_list') }}',
                    method: 'POST',
                    data: {
                        company: '{{ Request::segment(3) }}'
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.stocklists;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'company_name', title: 'Company Name'},
                                {data: 'warehouse_name', title: 'Warehouse Name'},
                                {data: 'container_number', title: 'Container Number'},
                                {data: 'no_of_packets', title: 'No of Packets'},
                                {data: 'date', title: 'Date'},
                                {data: 'description', title: 'Description'},
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var view_btn = '<a data-toggle="modal" data-target="#myModal" data-id="'+full['packet_list_id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 view_detail_btn">Sizes</a>';
                                        var edit_btn = '<a href="{{ url('stocklist/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';
                                        var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';
                                        return view_btn + " " + edit_btn + " " +delete_btn;
                                    }
                                }
                            ],
                            dom: 'Blrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'Excel',
                                    title: 'Stock List'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'PDF',
                                    title: 'Stock List'
                                }
                            ],
                            stateSave: true,
                        })
                    }
                })

            }

            $(document).on('click','.view_detail_btn',function(){
                var packetlist_id = $(this).data('id');
                $.ajax({
                    url: "{{ url('packetlist_detail/view') }}",
                    method: 'POST',
                    data: {
                        packetlist_id:packetlist_id
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        var parsed = JSON.parse(result);

                        var html = '';
                        $.each(parsed.packetlist_detail, function(k, v) {
                            html += '<tr>';
                            html += '<td>' + v.size + '</td>';
                            html += '</tr>';
                        });

                        $('.table_body').html(html);

                        console.log(parsed);
                    }

                })
                // alert(packetlist_id);
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
                            url: "{{ route('delete_stocklist') }}",
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
