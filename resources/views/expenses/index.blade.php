@php
    $html_tag_data = [];
    $title = 'Expense Setup';
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

                        <a href="{{ route('create_expense') }}" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                            <span>Add Expense</span>
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
                        <div class="card-body" >
                            <form class="form-inline" method="post" id="filter-form">
                                @csrf
                                <div class="form-group">
                                    <label for="">From Date <span class="required">*</span></label>
                                    <input name="from_date" id="from_date" type="text" autocomplete="off" class="form-control date-picker-close">
                                </div>
                                <div class="form-group">
                                    <label for="">To Date <span class="required">*</span></label>
                                    <input name="to_date" id="to_date" type="text" autocomplete="off" class="form-control date-picker-close">
                                </div>
                                <br>
                                <input type="button" value="Search" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1" id="search_btn">
                                <input type="button" value="Reset" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1" id="reset_btn">
                            </form>

                        </div>
                    </div>
                </section>
            </div>
        </div>

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
                    url: '{{ route('expense_list') }}',
                    method: 'POST',
                    data: $("#filter-form").serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: result => {

                        let data = JSON.parse(result);
                        console.log(data);
                        // return false;
                        var _data = data.expenses;

                        if ($.fn.DataTable.isDataTable('#ajax_table')) $('#ajax_table').DataTable().destroy();
                        $('#ajax_table').empty();
                        $('#ajax_table').DataTable({
                            // dom: 'Blfrtip',
                            data: _data,
                            aaSorting: [[ 0, "desc" ]],
                            columns: [
                                {data: 'description', title: 'Expense Description'},
                                {data: 'amount', title: 'Expense Amount'},
                                {data: 'date', title: 'Date'},
                                {
                                    title: 'Action',
                                    render: function (data, type, full, meta) {
                                        var edit_btn = '<a href="{{ url('expenses/edit') }}/'+full['id']+'" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Edit</a>';
                                        var delete_btn = '<a href="javascript:;" data-id="'+full['id']+'" id="delete_data" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">Delete</a>';
                                        return edit_btn + " " + delete_btn;
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
                            url: "{{ route('delete_expense') }}",
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


            $(document).ready(function(){
                $('#search_btn').click(function (){
                    fetchList();
                })
                $('#reset_btn').click(function (){
                    $('#from_date').val('');
                    $('#to_date').val('');
                    fetchList();
                })
            })

        </script>
        <!-- Order List End -->
    </div>
@endsection
