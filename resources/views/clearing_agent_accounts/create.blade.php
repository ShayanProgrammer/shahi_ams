@php
    $html_tag_data = [];
    $title = 'Add Clearing Agent';
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
                        <a href="{{ url('clearing_agents') }} }}" class="muted-link pb-1 d-inline-block breadcrumb-back">
                            <i data-cs-icon="chevron-left" data-cs-size="13"></i>
                            <span class="text-small align-middle">Home</span>
                        </a>
                        <h1 class="mb-0 pb-0 display-4" id="title">{{ $title }}</h1>
                    </div>
                </div>

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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ url('clearing_agent_account_store/') }}/{{ Request::segment(2) }}">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">BL Number <span class="required">*</span></label>
                                                <select class="select-single-no-search bl_number" data-placeholder="Select BL Number" name="bl_no" id="bl_no">
                                                    <option value="" selected>Select Bill Number</option>
                                                    @foreach($bl_numbers as $bl_number)
                                                        <option value="{{ $bl_number->bl_tracking }}">{{ $bl_number->bl_tracking }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Bill Number <span class="required">*</span></label>
                                            <input type="text" name="bill_no" autocomplete="off" class="form-control bill_no" value="{{ old('bill_no') }}" placeholder="Enter Bill Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">No of Container <span class="required">*</span></label>
                                            <input id="no_of_container" type="number" name="no_of_container" autocomplete="off" class="form-control" value="{{ old('no_of_container') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="required">*</span></label>
                                            <input type="text" name="date" autocomplete="off" class="form-control date-picker-close date" value="{{ old('date') }}" placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Debit <span class="required">*</span></label>
                                            <input type="text" name="debit" class="form-control debit" autocomplete="off" value="{{ old('debit') }}" id="debit" placeholder="Enter Debit Amount">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Credit <span class="required">*</span></label>
                                            <input type="text" min="1" name="credit" class="form-control credit" autocomplete="off" value="{{ old('credit') }}" id="credit" placeholder="Enter Credit Amount">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description <span class="required">*</span></label>
                                            <textarea name="description" class="form-control description" autocomplete="off" value="{{ old('description') }}" placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="button">
                                        <span>Save</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-save undefined"><path d="M5.5 18H14.5C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5V7.62041C18 6.93871 18 6.59786 17.8952 6.28697C17.849 6.14988 17.788 6.01821 17.7134 5.89427C17.5441 5.6132 17.2842 5.39268 16.7644 4.95163L14.2654 2.83122C13.8506 2.47926 13.6431 2.30328 13.403 2.19029C13.2968 2.14034 13.1865 2.09982 13.0732 2.06922C12.817 2 12.545 2 12.0009 2H5.5C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5V14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18Z"></path><path d="M14 18V13.75C14 13.0478 14 12.6967 13.8315 12.4444C13.7585 12.3352 13.6648 12.2415 13.5556 12.1685C13.3033 12 12.9522 12 12.25 12H7.75C7.04777 12 6.69665 12 6.44443 12.1685C6.33524 12.2415 6.24149 12.3352 6.16853 12.4444C6 12.6967 6 13.0478 6 13.75V18"></path><path d="M14 8L7.75 8C7.04777 8 6.69665 8 6.44443 7.83147C6.33524 7.75851 6.24149 7.66476 6.16853 7.55557C6 7.30335 6 6.95223 6 6.25L6 2"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('clearing_agents/clearing_agent_account/') }}/{{ Request::segment(2) }}">
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

        <!-- Order List End -->

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

    </div>
@endsection
