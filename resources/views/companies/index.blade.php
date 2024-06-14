@php
    $html_tag_data = [];
    $title = 'Company Setup';
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

{{--    {{ dd(auth()->user()) }}--}}
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-auto mb-3 mb-md-0 me-auto">
                    <div class="w-auto sw-md-50">
                        <a href="{{ url('dashboard') }}" class="muted-link pb-1 d-inline-block breadcrumb-back">
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

                        <a href="{{ route('create_company') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Company</span>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_change">Change</button>
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
                    url: '{{ route('company_list') }}',
                    method: 'POST',
                    data: $("#filter-form").serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.companies;
                        var role_id = "{{ auth()->user()->role_id }}";

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            searching: true,
                            columns: [
                                {data: 'created_at', title: 'Date'},
                                {data: 'name', title: 'Name'},
                                // {
                                //     title: 'Status',
                                //     render: function (data, type, full, meta) {
                                //         var status = "";
                                //
                                //         if(role_id == 1) {
                                //             status += '<a data-toggle="modal" data-target="#changeStatus" data-id="'+full['id']+'" data-status-id="'+full['status_id']+'" id="status_changer">';
                                //         }
                                //
                                //         if(full['status_id'] == 1) {
                                //             status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-success text-uppercase status_check">'+full['status']+'</span></div>';
                                //         } else if(full['status_id'] == 2) {
                                //             status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-warning text-uppercase status_check">'+full['status']+'</span></div>';
                                //         } else {
                                //             status += '<div class="h4"><span data-id="'+full['status_id']+'" class="badge bg-danger text-uppercase status_check">'+full['status']+'</span></div>';
                                //         }
                                //
                                //         if(role_id == 1) {
                                //             status += '</a>';
                                //         }
                                //
                                //         return status;
                                //
                                //     }
                                // },
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var edit_btn = '<a href="{{ url('companies/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';

                                        var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';

                                        var importstatuses_btn = '<a href="{{ url('importstatuses') }}/company/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Import Status</a>';

                                        @if($user->role_id == 1)
                                            var company_account_btn = '<a href="{{ url('company_accounts') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Account</a>';
                                        @else
                                            var company_account_btn = "";
                                        @endif

                                        return edit_btn + " " + delete_btn + " " + importstatuses_btn + " " + company_account_btn;
                                    }
                                }
                            ],
                            columnDefs: [
                                { targets: [0], visible: false, searchable: false } // Hide second column (index 1)
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
                        $.ajax({
                            url: "{{ route('delete_company') }}",
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

            @if(auth()->user()->role_id == 1)

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
                var table = "Company";

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
                        fetchList();
                    }
                })
            })

            {{--$(document).on('click','.status_check',function(){--}}
            {{--    var id = $(this).data('id');--}}

            {{--    // alert(id);--}}

            {{--    --}}{{--$.ajax({--}}
            {{--    --}}{{--    url: "{{ route('delete_company') }}",--}}
            {{--    --}}{{--    data: {--}}
            {{--    --}}{{--        id: id--}}
            {{--    --}}{{--    },--}}
            {{--    --}}{{--    method: 'POST',--}}
            {{--    --}}{{--    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },--}}
            {{--    --}}{{--    dataType: 'json',--}}
            {{--    --}}{{--    success: function(result){--}}
            {{--    --}}{{--        console.log(result);--}}
            {{--    --}}{{--        fetchList();--}}
            {{--    --}}{{--        $("#eq-loader").hide();--}}
            {{--    --}}{{--        if (result.HasError == 1) {--}}
            {{--    --}}{{--            Swal.fire({--}}
            {{--    --}}{{--                icon: 'error',--}}
            {{--    --}}{{--                title: 'Error',--}}
            {{--    --}}{{--                text: result.message,--}}
            {{--    --}}{{--            })--}}
            {{--    --}}{{--        }--}}
            {{--    --}}{{--        else{--}}
            {{--    --}}{{--            Swal.fire({--}}
            {{--    --}}{{--                icon: 'success',--}}
            {{--    --}}{{--                title: 'Operation Performed',--}}
            {{--    --}}{{--                text: result.message,--}}
            {{--    --}}{{--            })--}}
            {{--    --}}{{--        }--}}
            {{--    --}}{{--    }--}}
            {{--    --}}{{--})--}}
            {{--})--}}
            @endif
        </script>
        <!-- Order List End -->
    </div>
@endsection
