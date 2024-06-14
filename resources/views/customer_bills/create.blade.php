@php
    $html_tag_data = [];
    $title = 'Add Customer Bill';
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

                <!-- Top Buttons Start -->
            {{--                <div class="col-3 d-flex align-items-end justify-content-end">--}}
            {{--                    <!-- Check Button Start -->--}}
            {{--                    <div class="btn-group ms-1 check-all-container">--}}
            {{--                        <div class="btn btn-outline-primary btn-custom-control p-0 ps-3 pe-2" data-target="#checkboxTable">--}}
            {{--            <span class="form-check float-end">--}}
            {{--              <input type="checkbox" class="form-check-input" id="checkAll" />--}}
            {{--            </span>--}}
            {{--                        </div>--}}
            {{--                        <button--}}
            {{--                            type="button"--}}
            {{--                            class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"--}}
            {{--                            data-bs-offset="0,3"--}}
            {{--                            data-bs-toggle="dropdown"--}}
            {{--                            aria-haspopup="true"--}}
            {{--                            aria-expanded="false"--}}
            {{--                        ></button>--}}
            {{--                        <div class="dropdown-menu dropdown-menu-end">--}}
            {{--                            <a class="dropdown-item" href="#">--}}
            {{--                                <span class="align-middle d-inline-block">Status</span>--}}
            {{--                            </a>--}}
            {{--                            <a class="dropdown-item" href="#">--}}
            {{--                                <span class="align-middle d-inline-block">Move</span>--}}
            {{--                            </a>--}}
            {{--                            <a class="dropdown-item" href="#">--}}
            {{--                                <span class="align-middle d-inline-block">Delete</span>--}}
            {{--                            </a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <!-- Check Button End -->--}}
            {{--                </div>--}}
            <!-- Top Buttons End -->
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
                    <form class="tooltip-end-top" id="addressForm" novalidate="novalidate" method="post" action="{{ route('store_customer_bill') }}">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Bill Number</label>
                                            <input type="text" name="bill_no" autocomplete="off" id="bill_no" class="form-control" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Customer <span class="required">*</span></label>
                                                <select class="select-single-no-search customer" name="customer_id" data-placeholder="Select Customer">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input placeholder="Select Date" id="datePickerInputGroup" type="text" autocomplete="off" name="date" class="form-control date-picker-close date" value="{{ old('date') }}" autocomplete="off">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-calendar text-muted"><path d="M14.5 4C15.9045 4 16.6067 4 17.1111 4.33706C17.3295 4.48298 17.517 4.67048 17.6629 4.88886C18 5.39331 18 6.09554 18 7.5L18 14.5C18 15.9045 18 16.6067 17.6629 17.1111C17.517 17.3295 17.3295 17.517 17.1111 17.6629C16.6067 18 15.9045 18 14.5 18L5.5 18C4.09554 18 3.39331 18 2.88886 17.6629C2.67048 17.517 2.48298 17.3295 2.33706 17.1111C2 16.6067 2 15.9045 2 14.5L2 7.5C2 6.09554 2 5.39331 2.33706 4.88886C2.48298 4.67048 2.67048 4.48298 2.88886 4.33706C3.39331 4 4.09554 4 5.5 4L14.5 4Z"></path><path d="M2 9H18M7 2 7 5.5M13 2 13 5.5M5 15H6"></path></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Invoice <span class="required">*</span></label>
                                                <select class="select-single-no-search invoice" data-placeholder="Select Invoice Name" name="invoice" id="invoice">
                                                    <option value="" disabled selected>Select Invoice</option>
                                                    <option value="1">Unique</option>
                                                    <option value="2">M.Yaqoob</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#invoice').change(function() {
                                                var selectedInvoice = $(this).val();
                                                var invoicePrefix = '';

                                                if (selectedInvoice === '1') {
                                                    invoicePrefix = 'UN';
                                                } else if (selectedInvoice === '2') {
                                                    invoicePrefix = 'MY';
                                                }

                                                // console.log(invoicePrefix);
                                                // return;

                                                // Perform AJAX call to check for the latest invoice number in the database for the selected invoice
                                                // Replace 'your-api-url' with your actual API endpoint to fetch the latest invoice number for the selected invoice
                                                $.ajax({
                                                    url: '{{ url('get_bill_number_by_invoice') }}',
                                                    method: 'GET',
                                                    data: { invoice: invoicePrefix },
                                                    success: function(response) {
                                                        if (response.success) {
                                                            var latestInvoiceNumber = response.latestInvoiceNumber;

                                                            if (latestInvoiceNumber) {
                                                                // Extract the numeric part and increment by 1
                                                                var currentNumber = parseInt(latestInvoiceNumber.split('-')[1]);
                                                                var newNumber = currentNumber + 1;
                                                                var newInvoiceNumber = invoicePrefix + '-' + pad(newNumber, 2); // Use a function to ensure 2-digit numbering

                                                                $('#bill_no').val(newInvoiceNumber);
                                                            } else {
                                                                // If no invoice number exists, set the initial value as '01'
                                                                $('#bill_no').val(invoicePrefix + '-01');
                                                            }
                                                        }
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error(error);
                                                    }
                                                });
                                            });
                                        });

                                        // Function to pad the number with leading zeroes if needed
                                        function pad(number, length) {
                                            var str = '' + number;
                                            while (str.length < length) {
                                                str = '0' + str;
                                            }
                                            return str;
                                        }
                                    </script>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Payment Type <span class="required">*</span></label>
                                                <select class="select-single-no-search payment_type" data-placeholder="Select Payment Type" name="payment_type_id" id="payment_type_id">
                                                    <option value="" disabled selected>Select Payment Type</option>
                                                    @foreach($payment_types as $payment_type)
                                                        <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Wood Type <span class="required">*</span></label>
                                                <select class="select-single-no-search wood_type" data-placeholder="Select Wood Type" name="wood_type" id="wood_type">
                                                    <option value="" disabled selected>Select Wood Type</option>
                                                    <option value="soft">Soft</option>
                                                    <option value="hard">Hard</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        jQuery(document).ready(function() {
                                            jQuery('.wood_type').change(function() {
                                                var wood_type = jQuery(this).val();
                                                if(wood_type == 'hard') {
                                                    jQuery('.cbm_class').attr('readonly', 'readonly');
                                                } else {
                                                    jQuery('.cbm_class').removeAttr('readonly');
                                                }
                                            });
                                        });
                                    </script>

                                    <div class="col-md-4" id="description">
                                        <div class="mb-3">
                                            <label class="form-label">Description <span class="required">*</span></label>
                                            <textarea name="description" autocomplete="off" class="form-control"> {{ old('cheque_no') }} </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="display: none;" id="cheque_no_div">
                                        <div class="mb-3">
                                            <label class="form-label">Cheque Number <span class="required">*</span></label>
                                            <input type="text" name="cheque_no" autocomplete="off" class="form-control" value="{{ old('cheque_no') }}" placeholder="Enter Cheque Number">
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="display: none;" id="bank_div">
                                        <div class="mb-3">
                                            <div class="w-100" data-select2-id="1">
                                                <label class="form-label">Bank <span class="required">*</span></label>
                                                <select class="select-single-no-search bank" name="bank" id="bank">
                                                    <option value="" disabled>Select Bank</option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                 <div class="appendable_div" id="appendable_div">
                                    <div class="row g-3 repeatDiv" id="repeatDiv" style="margin-top:10px;">

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Warehouse <span class="required">*</span></label>
                                                    <select class="form-control warehouse_id" name="warehouse_id[]" id="warehouse_id" data-placeholder="Select Warehouse">
                                                        <option value="">Select Warehouse</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Company<span class="required">*</span></label>
                                                    <select class="form-control company_id" name="company_id[]" id="company_id" data-placeholder="Select Stock Container">
                                                        <option value="">Select Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Stock Container<span class="required">*</span></label>
                                                    <select class="form-control stocklist_id" name="stocklist_id[]" id="stocklist_id" data-placeholder="Select Stock Container">
                                                        <option value="">Select Stock Container</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Packet <span class="required">*</span></label>
                                                    <select class="form-control packetlist_id" name="packetlist_id[]" id="packetlist_id" data-placeholder="Select Packet">
                                                        <option value="">Select Packet</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Size</label>
                                                    <select class="form-control size_id" name="size_id[]" id="size_id" data-placeholder="Select Size">
                                                        <option value="">Select Size</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <div class="w-100">
                                                    <label class="form-label">Length</label>
                                                    <select class="form-control length_id" name="length_id[]" id="length_id" data-placeholder="Select Length">
                                                        <option value="">Select Length</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" name="quantity[]" autocomplete="off" class="form-control quantity_class" value="{{ old('quantity') }}" placeholder="Enter Quantity">
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label">CBM</label>
                                                <input type="text" name="cbm[]" autocomplete="off" class="form-control cbm_class" value="{{ old('cbm') }}" placeholder="Enter CBM">
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label">Rate <span class="required">*</span></label>
                                                <input type="text" name="rate[]" autocomplete="off" class="form-control rate_class" value="{{ old('rate') }}" placeholder="Enter Rate">
                                            </div>
                                        </div>

                                    </div>
                                     <div class="btn_div">
{{--                                        <a href="javascript:;" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1" id="addmore_btn">Add More</a>--}}
                                         <button type="button" class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 mt-20" style="margin-top: 10px;" id="repeatDivBtn" data-increment="1">Add More</button>
                                     </div>
                                 </div>
                            </div>
                            <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                <div>
                                    <button class="btn btn-lg btn-icon btn-icon-start btn-outline-primary ms-1 submit_btn" type="button">
                                        <span>Save</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-save undefined"><path d="M5.5 18H14.5C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5V7.62041C18 6.93871 18 6.59786 17.8952 6.28697C17.849 6.14988 17.788 6.01821 17.7134 5.89427C17.5441 5.6132 17.2842 5.39268 16.7644 4.95163L14.2654 2.83122C13.8506 2.47926 13.6431 2.30328 13.403 2.19029C13.2968 2.14034 13.1865 2.09982 13.0732 2.06922C12.817 2 12.545 2 12.0009 2H5.5C4.09554 2 3.39331 2 2.88886 2.33706C2.67048 2.48298 2.48298 2.67048 2.33706 2.88886C2 3.39331 2 4.09554 2 5.5V14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18Z"></path><path d="M14 18V13.75C14 13.0478 14 12.6967 13.8315 12.4444C13.7585 12.3352 13.6648 12.2415 13.5556 12.1685C13.3033 12 12.9522 12 12.25 12H7.75C7.04777 12 6.69665 12 6.44443 12.1685C6.33524 12.2415 6.24149 12.3352 6.16853 12.4444C6 12.6967 6 13.0478 6 13.75V18"></path><path d="M14 8L7.75 8C7.04777 8 6.69665 8 6.44443 7.83147C6.33524 7.75851 6.24149 7.66476 6.16853 7.55557C6 7.30335 6 6.95223 6 6.25L6 2"></path></svg>
                                    </button>
                                    <a class="btn btn-lg btn-icon-start btn-outline-primary ms-1" href="{{ url('customer_bills') }}">
                                        <span>Back</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-left"><path d="M13 16L7.35355 10.3536C7.15829 10.1583 7.15829 9.84171 7.35355 9.64645L13 4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <script>
                            $(document).ready(function(){

                                $('#cheque_no_div').hide();
                                $('#payment_type_id').change(function () {
                                    var selectedOption = $(this).val();
                                    if (selectedOption == '2') {
                                        $('#cheque_no_div').show();
                                        $('#bank_div').hide();
                                    } else if(selectedOption == '3') {
                                        $('#cheque_no_div').show();
                                        $('#bank_div').show();
                                    } else if(selectedOption == '4') {
                                        $('#bank_div').show();
                                        $('#cheque_no_div').hide();
                                    } else {
                                        $('#bank_div').hide();
                                        $('#cheque_no_div').hide();
                                    }
                                });

                                function validateDynamicField(warehouse_id,stocklist_id,packetlist_id,rate_class) {
                                    // Validation logic
                                    console.log('test');
                                    var warehouse_id = warehouse_id.val().trim();
                                    var stocklist_id = stocklist_id.val().trim();
                                    var packetlist_id = packetlist_id.val().trim();
                                    var rate_class = rate_class.val().trim();
                                    if (warehouse_id === '',stocklist_id === '',packetlist_id === '',rate_class === '') {
                                        // Handle validation error, e.g., display a message
                                        console.log('Field cannot be empty');
                                    } else {
                                        // Field is valid, perform other validation or actions
                                        console.log('Field is valid');
                                    }
                                }

                                // $('#myForm').on('input', '.dynamic-input', function() {
                                //     validateDynamicField($(this));
                                // });

                                $('.submit_btn').click(function(e){

                                    e.preventDefault();

                                    var invoice = $('.invoice').val();
                                    var customer = $('.customer').val();
                                    var date = $('.date').val();
                                    var payment_type = $('.payment_type').val();
                                    var warehouse_id = $('.warehouse_id').val();
                                    var stocklist_id = $('.stocklist_id').val();
                                    var packetlist_id = $('.packetlist_id').val();
                                    var size_id = $('.size_id').val();
                                    var length_id = $('.length_id').val();
                                    var rate_class = $('.rate_class').val();
                                    var quantity_class = $('.quantity_class').val();

                                    // console.log(customer);
                                    // console.log(date);
                                    // console.log(payment_type);

                                    // console.log(stocklist_id);
                                    // console.log(packetlist_id);
                                    // console.log(size_id);
                                    // console.log(length_id);
                                    // console.log(rate_class);
                                    // console.log(quantity_class);

                                    if(invoice === undefined || invoice === '' || invoice === null || customer === undefined || customer === '' || customer === null || payment_type === undefined || payment_type === '' || payment_type === null || date === ''){
                                        Swal.fire('Missing', 'Please fill the missing required fields.', 'error');
                                    } else {
                                        $('#addressForm').submit();
                                    }

                                    // $('.warehouse_id').each(function() {
                                    //     console.log($(this).val());
                                    //     if($(this).val() == '' || $(this).val() == null || $(this).val() == undefined) {
                                    //         Swal.fire('Missing', 'Please select the warehouse.', 'error');
                                    //     }
                                    //     return false;
                                    // });

                                    // $('.stocklist_id').each(function() {
                                    //     if($(this).val() == '') {
                                    //         Swal.fire('Missing', 'Please select the Stock List Container.', 'error');
                                    //     }
                                    //     return false;
                                    // });

                                    // $('.packetlist_id').each(function() {
                                    //     if($(this).val() == '') {
                                    //         Swal.fire('Missing', 'Please select the Packet.', 'error');
                                    //     }
                                    //     return false;
                                    // });

                                    // $('.rate_class').each(function() {
                                    //     if($(this).val() == '') {
                                    //         Swal.fire('Missing', 'Please add the rate.', 'error');
                                    //     }
                                    //     return false;
                                    // });


                                    // $('#addressForm').submit();
                                })

                            })
                        </script>
                </section>
            </div>
        </div>

        <script>
            $(document).ready(function () {

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


                $(document).on('keypress','.cbm_class',function(){
                    var row_id = $(this).parent().parent().parent().attr('id');

                    $(this).on('input', function() {
                        if ($(this).val().trim() === '') {

                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .length_id').val('');
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .size_id').val('');
                            $('#'+row_id+' .col-md-1 .mb-3 .quantity_class').val('');

                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .length_id').removeAttr("disabled");
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .size_id').removeAttr("disabled");
                            $('#'+row_id+' .col-md-1 .mb-3 .quantity_class').removeAttr("disabled");

                        } else {

                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .length_id').val('');
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .size_id').val('');
                            $('#'+row_id+' .col-md-1 .mb-3 .quantity_class').val('');

                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .length_id').attr('disabled', 'disabled');
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .size_id').attr('disabled', 'disabled');
                            $('#'+row_id+' .col-md-1 .mb-3 .quantity_class').attr('disabled', 'disabled');
                        }
                    });
                })

                $(document).on('change','.warehouse_id',function(){
                    var row_id = $(this).parent().parent().parent().parent().attr('id');
                    var warehouse_id = $(this).val();
                    // alert('#'+row_id+' .col-md-2 .mb-3 .w-100 .stocklist_id');
                    $.ajax({
                        url: '{{ route('get_company_by_warehouse') }}',
                        data: {
                            warehouse_id: warehouse_id,
                        },
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: 'json',
                        success: function(result){
                            var html_company = '';
                            html_company += '<option value="" selected>Select Container Number</option>';
                            $.each(result.company, function(k, v) {
                                html_company += '<option value='+v.id+'>'+v.company_name+'</option>';
                            });
                            $('#'+row_id+' .col-md-2 .mb-3 .w-100 .company_id').html(html_company);
                        }
                    })
                })

                $(document).on('change','.company_id',function(){
                    var row_id = $(this).parent().parent().parent().parent().attr('id');
                    var company_id = $(this).val();
                    // alert('#'+row_id+' .col-md-2 .mb-3 .w-100 .stocklist_id');
                    $.ajax({
                        url: '{{ route('get_stocklist_by_company') }}',
                        data: {
                            company_id: company_id,
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
                            $('#'+row_id+' .col-md-2 .mb-3 .w-100 .stocklist_id').html(html_stock);
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
                            console.log(result);
                            var html_packet = '';
                            html_packet += '<option value="" selected>Select Packing Item</option>';
                            $.each(result.packetlist, function(k, v) {
                                html_packet += '<option value='+v.id+'>'+v.description+'</option>';
                            });
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .packetlist_id').html(html_packet);
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
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .size_id').html(html_size);
                        }
                    })
                })

                $(document).on('change','.size_id',function(){
                    var row_id = $(this).parent().parent().parent().parent().attr('id');
                    var size_id = $(this).val();
                    $.ajax({
                        url: '{{ route('get_length_by_size') }}',
                        data: {
                            size_id: size_id,
                        },
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: 'json',
                        success: function(result){
                            var html_length = '';
                            html_length += '<option value="" selected>Select Length</option>';
                            $.each(result.lengths, function(k, v) {
                                html_length += '<option value='+v.id+'>'+v.length+'</option>';
                            });
                            $('#'+row_id+' .col-md-1 .mb-3 .w-100 .length_id').html(html_length);
                        }
                    })
                })

                $(document).on('change','.length_id',function(){
                    var row_id = $(this).parent().parent().parent().parent().attr('id');
                    var length_id = $(this).val();
                    $.ajax({
                        url: '{{ route('get_quantity_by_length') }}',
                        data: {
                            length_id: length_id,
                        },
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: 'json',
                        success: function(result){

                            $(document).on('change','.quantity_class',function(){
                                if(parseInt($(this).val()) > parseInt(result.quantity.quantity)) {
                                    Swal.fire('Limit Exceeded!', 'Quantity limit is ' + result.quantity.quantity + '.', 'error');
                                    $(this).val('');
                                }
                            });
                        }
                    })
                })
            });

            $(document).ready(function() {
                // $('.warehouse_id').select2({
                //     placeholder: "Select Warehouse",
                // });
                // $('.stocklist_id').select2({
                //     placeholder: "Select Stock List Container",
                // });
                // $('.packetlist_id').select2({
                //     placeholder: "Select Stock List Container",
                // });
                // $('.size_id').select2({
                //     placeholder: "Select Stock List Container",
                // });
                // $('.length_id').select2({
                //     placeholder: "Select Stock List Container",
                // });
            });
        </script>

    </div>
@endsection
