@php
    $html_tag_data = [];
    $title = 'Import Status Update';
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
                        <a href="{{ url('importstatuses') }}" class="muted-link pb-1 d-inline-block breadcrumb-back">
                            <i data-cs-icon="chevron-left" data-cs-size="13"></i>
                            <span class="text-small align-middle">Home</span>
                        </a>
                        <h1 class="mb-0 pb-0 display-4" id="title">{{ $title }}</h1>
                    </div>
                </div>
                <!-- Title End -->
            </div>
        </div>

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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ route('update_importstatus') }}">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $importstatus->id }}">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Company <span class="required">*</span></label>
                                                <select class="select-single-no-search company" name="company_id" data-placeholder="Select Company">
                                                    <option value="">Select Company</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}" {{ $company->id == $importstatus->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Performa <span class="required">*</span></label>
                                            <input type="text" name="performa" autocomplete="off" class="form-control performa" value="{{ $importstatus->performa }}" placeholder="Enter Performa">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input placeholder="Select Date" id="datePickerInputGroup" type="text" name="date" class="form-control date-picker-close date" value="{{ $importstatus->date }}" autocomplete="off">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-calendar text-muted"><path d="M14.5 4C15.9045 4 16.6067 4 17.1111 4.33706C17.3295 4.48298 17.517 4.67048 17.6629 4.88886C18 5.39331 18 6.09554 18 7.5L18 14.5C18 15.9045 18 16.6067 17.6629 17.1111C17.517 17.3295 17.3295 17.517 17.1111 17.6629C16.6067 18 15.9045 18 14.5 18L5.5 18C4.09554 18 3.39331 18 2.88886 17.6629C2.67048 17.517 2.48298 17.3295 2.33706 17.1111C2 16.6067 2 15.9045 2 14.5L2 7.5C2 6.09554 2 5.39331 2.33706 4.88886C2.48298 4.67048 2.67048 4.48298 2.88886 4.33706C3.39331 4 4.09554 4 5.5 4L14.5 4Z"></path><path d="M2 9H18M7 2 7 5.5M13 2 13 5.5M5 15H6"></path></svg>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description <span class="required">*</span></label>
                                            <textarea name="description" autocomplete="off" class="form-control description" placeholder="Enter Description">{{ $importstatus->description }}</textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <h1 class="mb-0 pb-0 display-4" id="title">Import Status Details:</h1>
                                    <div class="appendable_div" id="appendable_div">
                                        @php $count = 0; @endphp
                                        @if(empty($importstatus_details))
                                            <div class="row g-3 repeatDiv" id="repeatDiv_0" style="margin-top:10px;">
                                                <h1 class="mb-0 pb-0 display-4" id="title">Import Status Details:</h1>
                                                <input id="hidden_id" type="hidden" value="{{ $importstatus_detail->id != null ? $importstatus_detail->id : 0  }}" name="import_status_detail_id[]">
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">Rate <span class="required">*</span></label>
                                                            <input type="text" name="rate[]" autocomplete="off" class="form-control" id="rate_0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <label class="form-label">CBM <span class="required">*</span></label>
                                                            <input type="text" name="quantity[]" autocomplete="off" class="form-control" id="quantity_0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Length <span class="required">*</span></label>
                                                        <input type="text" name="length[]" autocomplete="off" class="form-control" id="length_0">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Size <span class="required">*</span></label>
                                                        <input type="text" name="size[]" autocomplete="off" class="form-control" id="size_0">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <div class="w-100">
                                                            <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $importstatus_detail->id }}" data-raw="@php echo $count; @endphp">X</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @foreach($importstatus_details as $importstatus_detail)

                                        <div class="row g-3 repeatDiv" id="repeatDiv@php if($count != 0){ echo "_".$count; } @endphp" style="margin-top:10px;">

                                            <input id="hidden_edit_id" type="hidden" value="{{ $importstatus_detail->id != null ? $importstatus_detail->id : 0  }}" name="import_status_detail_id[]">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <label class="form-label">Rate <span class="required">*</span></label>
                                                        <input type="text" name="rate[]" class="form-control rate_class" value="{{ $importstatus_detail->rate }}" id="rate_@php echo $count; @endphp">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <label class="-label">Quantity <span class="required">*</span></label>
                                                        <input type="text" name="quantity[]" class="form-control quantity_class" value="{{ $importstatus_detail->quantity }}" id="quantity_@php echo $count; @endphp">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Length <span class="required">*</span></label>
                                                    <input type="text" name="length[]" class="form-control length_class" value="{{ $importstatus_detail->length }}" id="length_@php echo $count; @endphp">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Size <span class="required">*</span></label>
                                                    <input type="text" name="size[]" class="form-control size_class" value="{{ $importstatus_detail->size }}" id="size_@php echo $count; @endphp">
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $importstatus_detail->id }}" data-raw="@php echo $count; @endphp">X</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @php $count++; @endphp
                                        @endforeach
                                        <div class="btn_div">
                                            <button type="button" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 mt-20" style="margin-top: 10px;" id="repeatDivBtn" data-increment="@php echo $count; @endphp">Add More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="submit">
                                        <span>Update</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-edit-square undefined"><path d="M11 2L5.5 2C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5L2 14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 11"></path><path d="M15.4978 3.06224C15.7795 2.78052 16.1616 2.62225 16.56 2.62225C16.9585 2.62225 17.3405 2.78052 17.6223 3.06224C17.904 3.34396 18.0623 3.72605 18.0623 4.12446C18.0623 4.52288 17.904 4.90497 17.6223 5.18669L10.8949 11.9141L8.06226 12.6223L8.7704 9.78966L15.4978 3.06224Z"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('importstatuses') }}">
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

                                    var company = $('.company').val();
                                    var performa = $('.performa').val();
                                    var date = $('.date').val();
                                    var description = $('.description').val();
                                    // var rate = $('.rate_class').val();
                                    // var quantity = $('.quantity_class').val();
                                    // var length = $('.length_class').val();
                                    // var size = $('.size_class').val();

                                    if(company === undefined || company === '' || company === null || performa === '' || date === '' || description === ''){
                                        Swal.fire('Missing', 'Please fill the missing required fields.', 'error');
                                    } else {
                                        $('#addressForm').submit();
                                    }
                                })

                            })
                        </script>
                </section>
{{--                <section class="scroll-section" id="basicSingle">--}}
{{--                    <h2 class="small-title">Basic Single</h2>--}}
{{--                    <div class="card mb-5">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row" data-select2-id="20">--}}
{{--                                <div class="col-12 col-sm-6 col-xl-4" data-select2-id="19">--}}
{{--                                    <div class="w-100" data-select2-id="1">--}}
{{--                                        <label class="form-label">City <span class="required">*</span></label>--}}
{{--                                        <select class="select-single-no-search">--}}
{{--                                            <option label="&nbsp;"></option>--}}
{{--                                            <option value="Tokyo" selected>Tokyo</option>--}}
{{--                                            <option value="...">...</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
            </div>
        </div>

        <!-- Order List End -->


    </div>

    <script>
        var $newid;

        $("#repeatDivBtn").click(function () {

            $newid = $(this).data("increment");
            $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
            // alert($repeatDiv);
            $('#repeatDiv').unwrap();
            $($repeatDiv).insertAfter($(".repeatDiv").last());
            $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid)
            $(".rate_class").last().attr('id',   "rate" + '_' + $newid)
            $(".quantity_class").last().attr('id',   "quantity" + '_' + $newid)
            $(".length_class").last().attr('id',   "length" + '_' + $newid)
            $(".size_class").last().attr('id',   "size" + '_' + $newid)
            $(".remove_raw_btn").last().attr('data-raw', $newid)
            $(".remove_raw_btn").last().attr('data-id', '')
            $("#repeatDiv" + '_' + $newid).find('input').val('');
            $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
            $newid++;
            $(this).data("increment", $newid);
        });

        $(document).on('click', '.removeDivBtn', function () {
            $divId = $(this).data("id");
            $("#"+$divId).remove();
            $inc = $("#repeatDivBtn").data("increment");
            $("#repeatDivBtn").data("increment", $inc-1);
        });

        $(document).on('click', '.remove_raw_btn', function () {
            $divId = $(this).data("raw");
            if($divId == 0) {
                $('#hidden_edit_id').val('');
                $('#rate_0').val('');
                $('#quantity_0').val('');
                $('#length_0').val('');
                $('#size_0').val('');
            } else {
                $("#repeatDiv_"+$divId).remove();
            }

            if($divId != '') {
                $id = $(this).data("id");
                $.ajax({
                    url: "{{ route('remove_single_importstatus') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: $id
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>
@endsection
