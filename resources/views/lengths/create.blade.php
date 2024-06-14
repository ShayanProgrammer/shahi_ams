@php
    $html_tag_data = [];
    $title = 'Add Packet List';
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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ route('store_packetlist') }}">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Warehouse <span class="required">*</span></label>
                                                <select class="select-single-no-search warehouse_id" name="warehouse_id">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Stock List <span class="required">*</span></label>
                                                <select class="select-single-no-search stocklist_id" name="stock_list_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Description <span class="required">*</span></label>
                                                <select class="select-single-no-search packetlist_id" name="packetlist_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Size <span class="required">*</span></label>
                                                <select class="select-single-no-search size_id" name="size_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="appendable_div" id="appendable_div">
                                    <div class="row g-3 repeatDiv" id="repeatDiv" style="margin-top:10px;">

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Length <span class="required">*</span></label>
                                                <input type="text" name="length[]" autocomplete="off" class="form-control length_class" value="{{ old('length') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Pieces <span class="required">*</span></label>
                                                    <input type="text" name="quantity[]" autocomplete="off" class="form-control quantity_class" value="{{ old('quantity') }}">
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="btn_div">
                                        <button type="button" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 mt-20" style="margin-top: 10px;" id="repeatDivBtn" data-increment="1">Add More</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="submit">
                                        <span>Save</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-save undefined"><path d="M5.5 18H14.5C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5V7.62041C18 6.93871 18 6.59786 17.8952 6.28697C17.849 6.14988 17.788 6.01821 17.7134 5.89427C17.5441 5.6132 17.2842 5.39268 16.7644 4.95163L14.2654 2.83122C13.8506 2.47926 13.6431 2.30328 13.403 2.19029C13.2968 2.14034 13.1865 2.09982 13.0732 2.06922C12.817 2 12.545 2 12.0009 2H5.5C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5V14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18Z"></path><path d="M14 18V13.75C14 13.0478 14 12.6967 13.8315 12.4444C13.7585 12.3352 13.6648 12.2415 13.5556 12.1685C13.3033 12 12.9522 12 12.25 12H7.75C7.04777 12 6.69665 12 6.44443 12.1685C6.33524 12.2415 6.24149 12.3352 6.16853 12.4444C6 12.6967 6 13.0478 6 13.75V18"></path><path d="M14 8L7.75 8C7.04777 8 6.69665 8 6.44443 7.83147C6.33524 7.75851 6.24149 7.66476 6.16853 7.55557C6 7.30335 6 6.95223 6 6.25L6 2"></path></svg>
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
                                    var length = $('.length_class').val();
                                    var quantity = $('.quantity_class').val();
                                    if(length.length === 0 || quantity.length === 0){
                                        Swal.fire('Missing', 'You must fill all data and at least 1 (size,length,quantity)', 'error');
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
            $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid);
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

        $(document).on('change','.stocklist_id',function(){
            var row_id = $(this).parent().parent().parent().parent().attr('id');
            var stocklist_id = $(this).val();
            $.ajax({
                url: '{{ route('get_packetlist_by_stocklist') }}',
                data: {
                    stocklist_id: stocklist_id,
                },
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(result){
                    var html_packet = '';
                    html_packet += '<option value="" selected>Select Packing Item</option>';
                    $.each(result.packetlist, function(k, v) {
                        html_packet += '<option value='+v.id+'>'+v.description+'</option>';
                    });
                    $('.packetlist_id').html(html_packet);
                }
            })
        })
        $(document).on('change','.packetlist_id',function(){
            var row_id = $(this).parent().parent().parent().parent().attr('id');
            var packetlist_id = $(this).val();
            $.ajax({
                url: '{{ route('get_size_by_packetlist') }}',
                data: {
                    packetlist_id: packetlist_id,
                },
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(result){
                    var html_size = '';
                    html_size += '<option value="" selected>Select Size</option>';
                    $.each(result.packetlist_details, function(k, v) {
                        html_size += '<option value='+v.id+'>'+v.size+'</option>';
                    });
                    $('.size_id').html(html_size);
                }
            })
        })
    </script>
@endsection
