@php
    $html_tag_data = [];
    $title = 'Length';
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
                        <h1>Length Detail</h1>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Length</th>
                                <th>Pieces</th>
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
                    url: '{{ url('length_list') }}',
                    method: 'POST',
                    data: {
                        company: '{{ Request::segment(3) }}'
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.lengths;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {
                                    title: 'Status',
                                    render: function (data, type, full, meta) {

                                        var status = '';
                                        var class_name = '';

                                        if(full['length_value'] != null){
                                            status = 'Added';
                                            class_name = 'btn-success';
                                        }else {
                                            status = 'Not Added';
                                            class_name = 'btn-danger';
                                        }

                                        return '<a href="javascript:;" class="btn btn-sm '+class_name+'"> </a>';
                                    }
                                },
                                {data: 'warehouse_name', title: 'Warehouse Name'},
                                {data: 'container_number', title: 'Stocklist Container'},
                                {data: 'description', title: 'Description'},
                                {data: 'size', title: 'Size'},
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var view_btn = '<a data-toggle="modal" data-target="#myModal" data-id="'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 view_detail_btn">View Detail</a>';
                                        {{--var edit_btn = '<a href="{{ url('length/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';--}}
                                        {{--var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';--}}
                                        var update_length = '<a href="{{ url('length/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Update Length</a>';

                                        return update_length + " " + view_btn;
                                    }
                                }
                            ],
                            dom: 'Blrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'Excel',
                                    title: 'Length'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions:{orthogonal: 'export'},
                                    text: 'PDF',
                                    title: 'Length'
                                }
                            ],
                            stateSave: true,
                        })
                    }
                })
            }

            $(document).on('click','.view_detail_btn',function(){
                var length_id = $(this).data('id');
                $.ajax({
                    url: "{{ url('length_detail/view') }}",
                    method: 'POST',
                    data: {
                        length_id:length_id
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(result){
                        var parsed = JSON.parse(result);

                        var html = '';
                        $.each(parsed.length_detail, function(k, v) {
                            html += '<tr>';
                            html += '<td>' + v.length + '</td>';
                            html += '<td>' + v.quantity + '</td>';
                            html += '</tr>';
                        });

                        $('.table_body').html(html);

                        console.log(parsed);
                    }

                })
                // alert(length_id);
            })
        </script>
        <!-- Order List End -->
    </div>
@endsection
