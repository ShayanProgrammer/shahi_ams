@php
    $html_tag_data = [];
    $title = 'Packet List Update';
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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ route('update_packetlist') }}">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $packetlist->id }}">
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Warehouse <span class="required">*</span></label>
                                                <select class="select-single-no-search warehouse_id" name="warehouse_id">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == $packetlist->warehouse_id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Stock List <span class="required">*</span></label>
                                                <select class="stocklist_id" name="stock_list_id">
                                                    <option value="">Select Container Number</option>
                                                    @foreach($stocklists as $stocklist)
                                                        <option value="{{ $stocklist->id }}" {{ $stocklist->id == $packetlist->stock_list_id ? 'selected' : '' }}>{{ $stocklist->container_number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Description <span class="required">*</span></label>
                                            <input type="text" name="description" autocomplete="off" class="form-control description" id="description" value="{{ $packetlist->description }}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <h1 class="mb-0 pb-0 display-4" id="title">Packet List Detail:</h1>
                                <div class="appendable_div" id="appendable_div">
                                    @php $count = 0; @endphp
                                    @if(empty($packetlist_details))
                                        <div class="row g-3 repeatDiv" id="repeatDiv_0" style="margin-top:10px;">

                                            <input id="hidden_id" type="hidden" value="{{ $packetlist_detail->id != null ? $packetlist_detail->id : 0  }}" name="packetlist_detail_id[]">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <label class="form-label">Size <span class="required">*</span></label>
                                                        <input type="text" name="size[]" autocomplete="off" class="form-control" id="size_0">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $packetlist_detail->id }}" data-raw="@php echo $count; @endphp">X</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @foreach($packetlist_details as $packetlist_detail)

                                        <div class="row g-3 repeatDiv" id="repeatDiv@php if($count != 0){ echo "_".$count; } @endphp" style="margin-top:10px;">

                                            <input id="hidden_edit_id" type="hidden" value="{{ $packetlist_detail->id != null ? $packetlist_detail->id : 0  }}" name="packetlist_detail_id[]">

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Size <span class="required">*</span></label>
                                                    <input type="text" name="size[]" class="form-control size_class" value="{{ $packetlist_detail->size }}" id="size_@php echo $count; @endphp">
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="mb-3">
                                                    <div class="w-100">
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1 remove_raw_btn" data-id="{{ $packetlist_detail->id }}" data-raw="@php echo $count; @endphp">X</a>
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
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="button">
                                        <span>Update</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-edit-square undefined"><path d="M11 2L5.5 2C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5L2 14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 11"></path><path d="M15.4978 3.06224C15.7795 2.78052 16.1616 2.62225 16.56 2.62225C16.9585 2.62225 17.3405 2.78052 17.6223 3.06224C17.904 3.34396 18.0623 3.72605 18.0623 4.12446C18.0623 4.52288 17.904 4.90497 17.6223 5.18669L10.8949 11.9141L8.06226 12.6223L8.7704 9.78966L15.4978 3.06224Z"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('packetlists') }}">
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

                                var warehouse_id = $('.warehouse_id').val();
                                var stocklist_id = $('.stocklist_id').val();
                                var description = $('.description').val();

                                if(warehouse_id === undefined || warehouse_id === '' || warehouse_id === null || stocklist_id === undefined || stocklist_id === '' || stocklist_id === null || description === ''){
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
                $('#size_0').val('');
            } else {
                $("#repeatDiv_"+$divId).remove();
            }


            if($divId != '') {
                $id = $(this).data("id");
                $.ajax({
                    url: "{{ route('remove_single_packetlist') }}",
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

        $(document).on('change','.warehouse_id',function(){
            var warehouse_id = $(this).val();
            $.ajax({
                url: '{{ route('get_stocklist_by_warehouse') }}',
                data: {
                    warehouse_id: warehouse_id,
                },
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(result){
                    var html_stock = '';
                    html_stock += '<option value="" selected>Select Container Number</option>';
                    $.each(result.stocklist, function(k, v) {
                        html_stock += '<option value='+v.id+'>'+v.container_number+'</option>';
                    });
                    $('.stocklist_id').html(html_stock);
                }
            })
        })

        $(document).ready(function() {
            $('.stocklist_id').select2({
                placeholder: "Select Stock List Container",
            });
        });
    </script>
@endsection
