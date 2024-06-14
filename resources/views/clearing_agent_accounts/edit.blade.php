@php
    $html_tag_data = [];
    $title = 'Clearing Agent Update';
    $description= ''
@endphp
@extends('layout',[
'html_tag_data'=>$html_tag_data,
'title'=>$title,
'description'=>$description
])

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
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Order List Start -->
        <div class="row">
            <div class="col-12 mb-5">
                <section class="scroll-section" id="address">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ url('clearing_agent_account_update') }}/{{ Request::segment(2) }}">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $clearing_agent->id }}">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">BL Number <span class="required">*</span></label>
                                                <select class="select-single-no-search bl_number" data-placeholder="Select BL Number" name="bl_no" id="bl_no">
                                                    <option value="" disabled>Select BL Number</option>
                                                    @foreach($bl_numbers as $bl_number)
                                                        <option value="{{ $bl_number->bl_tracking }}" {{ $bl_number->bl_tracking == $clearing_agent->bl_no ? 'selected' : '' }}>{{ $bl_number->bl_tracking }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Bill No <span class="required">*</span></label>
                                            <input id="bill_no" type="text" name="bill_no" class="form-control bill_no" autocomplete="off" value="{{ $clearing_agent->bill_no }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">No of Container <span class="required">*</span></label>
                                            <input id="no_of_container" type="number" name="no_of_container" class="form-control no_of_container" autocomplete="off" value="{{ $clearing_agent->no_of_container }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="required">*</span></label>
                                            <input id="date" type="text" name="date" class="form-control date-picker-close date" autocomplete="off" value="{{ $clearing_agent->date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Debit <span class="required">*</span></label>
                                            <input id="debit" type="text" min="1" name="debit" class="form-control debit" autocomplete="off" value="{{ $clearing_agent->debit }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Credit <span class="required">*</span></label>
                                            <input id="credit" type="text" name="credit" class="form-control credit" autocomplete="off" value="{{ $clearing_agent->credit }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description <span class="required">*</span></label>
                                            <textarea name="description" class="form-control description" autocomplete="off">{{ $clearing_agent->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="button">
                                        <span>Update</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-edit-square undefined"><path d="M11 2L5.5 2C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5L2 14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 11"></path><path d="M15.4978 3.06224C15.7795 2.78052 16.1616 2.62225 16.56 2.62225C16.9585 2.62225 17.3405 2.78052 17.6223 3.06224C17.904 3.34396 18.0623 3.72605 18.0623 4.12446C18.0623 4.52288 17.904 4.90497 17.6223 5.18669L10.8949 11.9141L8.06226 12.6223L8.7704 9.78966L15.4978 3.06224Z"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('clearing_agents/clearing_agent_account/') }}/{{ $clearing_agent->clearing_agent_id }}">
                                        <span>Back</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-left"><path d="M13 16L7.35355 10.3536C7.15829 10.1583 7.15829 9.84171 7.35355 9.64645L13 4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <script>
                            $(document).ready(function(){

                                $('.submit_btn').click(function(){

                                    var bl_number = $('.bl_number').val();
                                    var bill_no = $('.bill_no').val();
                                    var date = $('.date').val();
                                    var description = $('.description').val();
                                    var debit = $('.debit').val();
                                    var credit = $('.credit').val();


                                    if(bl_number === '' || bill_no === '' || date === '' || description === ''){
                                        Swal.fire('Missing', 'Please fill the missing required fields.', 'error');
                                    } else {
                                        $('#addressForm').submit();
                                    }
                                })

                            })
                        </script>
                </section>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function(){
            $('#debit').on('keyup', function(){
                var credit = $('#credit').val();
                if(credit != '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "You can either add debit or credit at a time.",
                    })
                    $('#debit').val('');
                }
            })

            $('#credit').on('keyup', function(){
                var debit = $('#debit').val();
                if(debit != '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "You can either add debit or credit at a time.",
                    })
                    $('#credit').val('');
                }
            })
        })
        $(document).on('change','#bl_no',function(){
            var bl_number = $(this).val();
            $.ajax({
                url: '{{ route('get_number_of_container_by_bl_number') }}',
                data: {
                    bl_number: bl_number,
                },
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(result){

                    console.log(result);
                    $('#no_of_container').val(result.no_of_container.no_of_container);
                }
            })
        })
    </script>
@endsection
