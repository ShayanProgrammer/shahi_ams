<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>Customer Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body{margin-top:20px;
            background-color:#eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: 1rem;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Invoice # {{ $customer_details->invoice_number }}
{{--                            <span class="badge bg-success font-size-12 ms-2">Paid on {{ $customer_details->payment_type_name }}</span>--}}
                        </h4>
                        <div class="mb-4">
                            <h2 class="mb-1 text-muted">M.Yaqoob Traders</h2>
                        </div>
{{--                        <div class="text-muted">--}}
{{--                            <p class="mb-1">3184 Spruce Drive Pittsburgh, PA 15201</p>--}}
{{--                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="c5bdbcbf85fcfdf2eba6aaa8">[email&#160;protected]</a></p>--}}
{{--                            <p><i class="uil uil-phone me-1"></i> 012-345-6789</p>--}}
{{--                        </div>--}}
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Billed To:</h5>
                                <h5 class="font-size-15 mb-2">{{ $customer_details->name }}</h5>
                                <p class="mb-1">{{ $customer_details->phone }}</p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                    <p># {{ $customer_details->invoice_number }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                    <p>{{ $today }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="py-2">
                        <h3 class="font-size-15">Order Detail</h3>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0 table-bordered table-hover" style="border: solid 1px;">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">S.No#</th>
                                    <th style="width: 400px;">Item</th>
                                    <th>Size</th>
                                    <th>Length</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th class="text-end" style="width: 120px;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($customer_bill_details))
                                    @foreach($customer_bill_details as $customer_bill_detail)
                                        <tr>
                                            <td scope="row">{{ $customer_bill_detail->serial_number }}</td>
                                            <td>{{ $customer_bill_detail->description }}
{{--                                                <div>--}}
{{--                                                    <h5 class="text-truncate font-size-14 mb-1">{{ $customer_bill_detail->description }}</h5>--}}
{{--    --}}{{--                                                <p class="text-muted mb-0">Watch, Black</p>--}}
{{--                                                </div>--}}
                                            </td>
                                            <td>{{ $customer_bill_detail->size }}</td>
                                            <td>{{ $customer_bill_detail->length }}</td>
                                            <td>{{ $customer_bill_detail->rate }}</td>
                                            <td>{{ $customer_bill_detail->quantity }}</td>
                                            <td class="text-end">
                                                @php
                                                    if($customer_bill_detail->cbm == '') {
                                                        $size = $customer_bill_detail->size;
                                                        $size = str_replace('X', 'x', $size);
                                                        $size = str_replace(' ', '', $size);
                                                        $sizeArray = explode('x', $size);
                                                        $sizeCalc = array_map('intval', $sizeArray);
                                                        $finalSize = array_product($sizeCalc);
                                                        $length = $customer_bill_detail->length;
                                                        $cbm = $finalSize * $length * $customer_bill_detail->quantity / 1000000;
                                                    } else {
                                                        $cbm = $customer_bill_detail->cbm;

                                                    }

//                                                    $finalCBM = (float)number_format($cbm, 3);
                                                    $squarefit = $cbm * 35.3147;
//                                                    $finalSquareFit = round($squarefit, 3);
                                                    $total_calc = $squarefit * $customer_bill_detail->rate;
                                                    $total = (int)round($total_calc);
                                                    echo $total;
                                                @endphp

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                <tr>
                                    <th scope="row" colspan="6" class="text-end">Sub Total</th>
                                    <td class="text-end">{{ $customer_details->total }}</td>
                                </tr>

{{--                                <tr>--}}
{{--                                    <th scope="row" colspan="4" class="border-0 text-end">--}}
{{--                                        Discount :</th>--}}
{{--                                    <td class="border-0 text-end">- $25.50</td>--}}
{{--                                </tr>--}}

{{--                                <tr>--}}
{{--                                    <th scope="row" colspan="4" class="border-0 text-end">--}}
{{--                                        Shipping Charge :</th>--}}
{{--                                    <td class="border-0 text-end">$20.00</td>--}}
{{--                                </tr>--}}

{{--                                <tr>--}}
{{--                                    <th scope="row" colspan="4" class="border-0 text-end">--}}
{{--                                        Tax</th>--}}
{{--                                    <td class="border-0 text-end">$12.00</td>--}}
{{--                                </tr>--}}

                                <tr>
                                    <th scope="row" colspan="6" class="border-0 text-end" style="font-size: 22px;">Total</th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{ $customer_details->total }}</h4></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
{{--                                <a href="#" class="btn btn-primary w-md">Send</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
