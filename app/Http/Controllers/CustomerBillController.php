<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\CustomerBill;
use App\Models\CustomerBillDetail;
use App\Models\Length;
use App\Models\PacketList;
use App\Models\PacketListDetail;
use App\Models\PaymentType;
use App\Models\StockList;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CustomerBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_bills = CustomerBill::latest()->paginate(10);
        return view('customer_bills.index',compact('customer_bills'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function invoice($id)
    {
        $customer_details = CustomerBill::join('customers','customers.id','=', 'customer_bills.customer_id')
            ->join('payment_types','payment_types.id','=', 'customer_bills.payment_type_id')
        ->where('customer_bills.id', $id)
        ->select('customers.name','customers.phone','customer_bills.invoice_number','customer_bills.payment_type_id','customer_bills.cheque_no','customer_bills.total','payment_types.name as payment_type_name')
        ->first();


        $customer_bill_details = CustomerBillDetail::leftjoin('packet_list_details', 'packet_list_details.id', '=', 'customer_bill_details.packetlist_detail_id')
            ->leftjoin('lengths', 'lengths.id', '=', 'customer_bill_details.length_id')
            ->leftjoin('packet_lists', 'packet_lists.id', '=', 'customer_bill_details.packetlist_id')
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY customer_bill_details.id) AS serial_number, packet_lists.description, packet_list_details.size,lengths.length, customer_bill_details.rate, customer_bill_details.quantity,customer_bill_details.cbm')
            ->where('customer_bill_details.customer_bill_id', $id)
            ->get();

//        dd($customer_bill_details);


        $mytime = Carbon::now();
        $today = $mytime->toFormattedDateString();


        return view('invoices.index',compact('customer_details','customer_bill_details','today'));
    }

    public function get_stocklist_by_warehouse(Request $request)
    {
        $stocklists = StockList::where('warehouse_id',$request->warehouse_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'stocklist' => $stocklists,
        ]);
    }

    public function get_company_by_warehouse(Request $request)
    {
        $companies = StockList::join('companies','companies.id','=','stock_lists.company_id')
            ->where('stock_lists.warehouse_id',$request->warehouse_id)
            ->where('companies.is_deleted', 0)
            ->select('companies.id','companies.name as company_name')
            ->distinct()
            ->get();

        echo json_encode([
            'company' => $companies,
        ]);
    }

    public function get_stocklist_by_company(Request $request)
    {
        $stocklists = StockList::where('company_id',$request->company_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'stocklist' => $stocklists,
        ]);
    }

    public function get_stocklist_by_warehouse_and_company(Request $request)
    {
        if($request->warehouse_id == null) {
            $stocklists = StockList::where('company_id',$request->company_id)->where('is_deleted', 0)->get();
        } elseif($request->company_id == null) {
            $stocklists = StockList::where('warehouse_id',$request->warehouse_id)->where('is_deleted', 0)->get();
        } else {
            $stocklists = StockList::where('warehouse_id',$request->warehouse_id)->where('company_id',$request->company_id)->where('is_deleted', 0)->get();
        }

        echo json_encode([
            'stocklist' => $stocklists,
        ]);
    }

    public function get_packetlist_by_stocklist(Request $request)
    {

        $packetlists = PacketList::where('stock_list_id',$request->stocklist_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'packetlist' => $packetlists,
        ]);
    }

    public function get_size_by_packetlist(Request $request)
    {
        $packetlist_details = PacketListDetail::where('packet_list_id',$request->packetlist_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'packetlist_details' => $packetlist_details,
        ]);
    }

    public function get_length_by_size(Request $request)
    {
        $lengths = Length::where('packet_list_detail_id',$request->size_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'lengths' => $lengths,
        ]);
    }

    public function get_quantity_by_length(Request $request)
    {
        $quantity = Length::where('id',$request->length_id)->where('is_deleted', 0)->first();
        echo json_encode([
            'quantity' => $quantity,
        ]);
    }

    public function customer_bill_list(Request $request){
        try{
            $query = DB::table('customer_bills')
            ->join('customers','customers.id','=','customer_bills.customer_id')
            ->join('payment_types','payment_types.id','=','customer_bills.payment_type_id')
            ->join('status','status.id','=','customer_bills.status_id')
            ->select('customer_bills.*','customers.name as customer_name','payment_types.name as payment_type','status.status');



//            if(isset($request->start) && !empty($request->start)){
//                $query->whereDate('client_leads.created_at', '>=', $request->start);
//            }
//            if(isset($request->end) && !empty($request->end)){
//                $query->whereDate('client_leads.created_at', '<=', $request->end);
//            }
//            if(isset($request->city_id) && !empty($request->city_id)){
//                $query->where('client_leads.city_id', '=', $request->city_id);
//            }
//            if(isset($request->class_id) && !empty($request->class_id)){
//                $array_class    = explode("-",$request->class_id,3);
//                $query->where('client_leads.class_id', '=', $array_class[0]);
//                $query->where('client_leads.class_category_id', '=', $array_class[1]);
//            }
//            if(isset($request->type_id) && !empty($request->type_id)){
//                $query->where('users.type', '=', $request->type_id);
//            }

            $customer_bills = $query->where('customer_bills.is_deleted',0)->get();

            echo json_encode([
                'customer_bills' => $customer_bills
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('is_deleted', 0)->get();
        $banks = Bank::where('is_deleted', 0)->get();
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        $stocklists = StockList::where('is_deleted', 0)->get();
        $packetlists = PacketList::where('is_deleted', 0)->get();
        $payment_types = PaymentType::where('is_deleted', 0)->get();
//        $latestBillId = CustomerBill::latest('id')->pluck('id')->first();
//        $formattedBillNumber = 'BN-' . str_pad($latestBillId + 1, 2, '0', STR_PAD_LEFT);
        return view('customer_bills.create',compact('banks','stocklists', 'packetlists','warehouses','customers','payment_types'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'customer_id' => 'required',
            'date' => 'required',
            'bill_no' => 'required',
            'payment_type_id' => 'required',
        ], [
            'customer_id.required' => 'Customer Name is required',
            'date.required' => 'Date is required',
            'payment_type_id.required' => 'Payment Type is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $customer_bill = new CustomerBill([
            'invoice_number' => $request->get('bill_no'),
            'customer_id' => $request->get('customer_id'),
            'date' => $request->get('date'),
            'payment_type_id' => $request->get('payment_type_id'),
            'cheque_no' => $request->get('cheque_no'),
            'wood_type' => $request->get('wood_type'),
            'description' => $request->get('description'),
            'bank_id' => $request->get('bank'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        //Insert Bill
        $customer_bill->save();



        $arr = array();
        foreach ($request->warehouse_id as $key => $value) {
            $arr[] = [
                'warehouse_id' => $value,
                'customer_bill_id' => $customer_bill->id,
                'stocklist_id' => $request->stocklist_id[$key]??'',
                'packetlist_id' => $request->packetlist_id[$key]??'',
                'packetlist_detail_id' => $request->size_id[$key]??null,
                'length_id' => $request->length_id[$key]??null,
                'rate' => $request->rate[$key]??'',
                'quantity' => $request->quantity[$key]??'',
                'cbm' => $request->cbm[$key]??'',
            ];
        }

        //Insert Bill Details
        CustomerBillDetail::insert($arr);

        $product_arr = array();
        foreach ($request->warehouse_id as $key => $product) {

            if($request->cbm[$key] == null && $request->wood_type == 'soft') {

                $size_data = PacketListDetail::where('id',$request->size_id[$key])->first();
                $size = $size_data->size;

                $size = str_replace('X', 'x', $size);
                $size = str_replace(' ', '', $size);

                $sizeArray = explode('x', $size);
                $sizeCalc = array_map('intval', $sizeArray);
                $finalSize = array_product($sizeCalc);

                $length_data = Length::where('id',$request->length_id[$key])->first();

                $length_data->quantity -= $request->quantity[$key];
                $length_data->save();


                $length = $length_data->length;

                $cbm = $finalSize * $length * $request->quantity[$key] / 1000000;

                $squarefit = $cbm * 35.3147;
            } else {
                $squarefit = $request->cbm[$key] * 35.3147;

                $all = PacketList::leftjoin('packet_list_details','packet_list_details.packet_list_id','=','packet_lists.id')
                    ->leftjoin('lengths','lengths.packet_list_detail_id','=','packet_list_details.id')
                    ->where('packet_lists.id',$request->packetlist_id[$key])
                    ->where('lengths.is_deleted', 0)
                    ->select('lengths.*')
                    ->get();

                foreach($all as $a) {
                    $length = Length::where('id',$a->id)->first();
                    $length->quantity = 0;
                    $length->save();
                }
            }

            if($request->cbm[$key] == null && $request->wood_type == 'hard') {

                $size_data = PacketListDetail::where('id',$request->size_id[$key])->first();
                $size = $size_data->size;

                $size = str_replace('X', 'x', $size);
                $size = str_replace(' ', '', $size);

                $sizeArray = explode('x', $size);
                $sizeCalc = array_map('intval', $sizeArray);
                $finalSize = array_product($sizeCalc);

                $length_data = Length::where('id',$request->length_id[$key])->first();

                $length_data->quantity -= $request->quantity[$key];
                $length_data->save();


                $length = $length_data->length;

                $squarefit = $finalSize * $length * $request->quantity[$key] / 144;

            } else {

                $all = PacketList::leftjoin('packet_list_details','packet_list_details.packet_list_id','=','packet_lists.id')
                    ->leftjoin('lengths','lengths.packet_list_detail_id','=','packet_list_details.id')
                    ->where('packet_lists.id',$request->packetlist_id[$key])
                    ->where('lengths.is_deleted', 0)
                    ->select('lengths.*')
                    ->get();

                foreach($all as $a) {
                    $length = Length::where('id',$a->id)->first();
                    $length->quantity = 0;
                    $length->save();
                }
            }




//            $finalSquareFit = round($squarefit, 3);

            $total_calc = $squarefit * $request->rate[$key];

            $total = (int)round($total_calc);

            $product_arr[] = [
                'total' => $total
            ];
        }

        $totalValues = array_column($product_arr, 'total');
        $total = array_sum($totalValues);

//        foreach($product_arr as $a) {
//            $total += (int)$a['total'];
//        }

        if($request->get('payment_type_id') == 3 || $request->get('payment_type_id') == 4) {
            $bank_account = new BankAccount();
            if($request->get('payment_type_id') == 3) {
                $bank_account->cheque_no = $request->get('cheque_no');
                $bank_account->bank_id = $request->get('bank');
            } else {
                $bank_account->bank_id = $request->get('bank');
            }
            $bank_account->customer_bill_id = $customer_bill->id;
            $bank_account->debit = $total;
            $bank_account->save();
        }


        //Calculate Total Amount
        CustomerBill::where('id',$customer_bill->id)->update(['total'=>$total]);

        $customer_account = new CustomerAccount([
            'customer_id' => $request->get('customer_id'),
            'customer_bill_id' => $customer_bill->id,
            'paid_payment' => 'Bill',
            'debit' => $total
        ]);

        $customer_account->save();

        return redirect()->route('customer_bills')
            ->with('success','Customer Bill created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerBill $customer_bill)
    {
        return view('customer_bills.show',compact('customer_bill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $customer_bill = CustomerBill::where('id',$id)->first();
        $banks = Bank::where('is_deleted', 0)->get();
        $customers = Customer::where('is_deleted', 0)->get();
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        $stocklists = StockList::where('is_deleted', 0)->get();
        $packetlists = PacketList::where('is_deleted', 0)->get();
        $packetlistdetails = PacketListDetail::where('is_deleted', 0)->get();
        $lengths = Length::where('is_deleted', 0)->get();
        $payment_types = PaymentType::where('is_deleted', 0)->get();
        $customer_bill_details = CustomerBillDetail::where('customer_bill_id', $customer_bill->id)->where('is_deleted', 0)->get();
        return view('customer_bills.edit',compact('banks','lengths','packetlistdetails','customer_bill','customer_bill_details','customers','warehouses','stocklists','packetlists','payment_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'customer_id' => 'required',
            'date' => 'required',
            'payment_type_id' => 'required',
        ], [
            'customer_id.required' => 'Customer Name is required',
            'date.required' => 'Date is required',
            'payment_type_id.required' => 'Payment Type is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $customer_bill = CustomerBill::find($request->id);
        $customer_bill->customer_id = $request->get('customer_id');
        $customer_bill->date = $request->get('date');
        $customer_bill->payment_type_id = $request->get('payment_type_id');
        $customer_bill->cheque_no = $request->get('cheque_no');
        $customer_bill->bank_id = $request->get('bank');
        $customer_bill->added_by = Auth()->user()->name;
        $customer_bill->status_id = $status;
        $customer_bill->action = 'Update';
        //Update Bill
        $customer_bill->save();

        $product_arr = array();
        foreach ($request->warehouse_id as $key => $product) {

            $size_data = PacketListDetail::where('id',$request->size_id[$key])->first();
            $size = $size_data->size;
            $sizeArray = explode('x', $size);
            $sizeCalc = array_map('intval', $sizeArray);
            $finalSize = array_product($sizeCalc);

            $length_data = Length::where('id',$request->length_id[$key])->first();
            $length = $length_data->length;

            $cbm = $finalSize * $length * $request->quantity[$key] / 1000000;
//            $finalCBM = (float)number_format($cbm, 3);

            $squarefit = $cbm * 35.3147;
//            $finalSquareFit = round($squarefit, 3);

            $total_calc = $squarefit * $request->rate[$key];

            $total = (int)round($total_calc);

            $product_arr[] = [
                'total' => $total
            ];
        }

        $totalValues = array_column($product_arr, 'total');
        $total = array_sum($totalValues);

        if($request->get('payment_type_id') == 3 || $request->get('payment_type_id') == 4) {
            $bank_account = BankAccount::where('customer_bill_id',$request->id)->first();
            if($request->get('payment_type_id') == 3) {
                $bank_account->cheque_no = $request->get('cheque_no');
                $bank_account->bank_id = $request->get('bank');
            } else {
                $bank_account->bank_id = $request->get('bank');
            }
            $bank_account->customer_bill_id = $customer_bill->id;
            $bank_account->debit = $total;
            $bank_account->save();
        }


        //Calculate Total Amount
        CustomerBill::where('id',$customer_bill->id)->update(['total'=>$total]);

        for($i = 0; $i < count($request->warehouse_id); $i++) {
            $customer_bill_detail_array[] = [
                'id' => $request->customer_bill_detail_id[$i],
                'customer_bill_id' => $request->id,
                'warehouse_id' => $request->warehouse_id[$i],
                'stocklist_id' => $request->stocklist_id[$i],
                'packetlist_id' => $request->packetlist_id[$i],
                'packetlist_detail_id' => $request->size_id[$i],
                'length_id' => $request->length_id[$i],
                'rate' => $request->rate[$i],
                'quantity' => $request->quantity[$i],
            ];
        }

        foreach($customer_bill_detail_array as $key => $detail_array) {
            if($detail_array['id'] == null) {
                CustomerBillDetail::insert($detail_array);
            } else {
                CustomerBillDetail::where('id', $detail_array['id'])
                    ->update([
                        'warehouse_id' => $request->warehouse_id[$key],
                        'stocklist_id' => $request->stocklist_id[$key],
                        'packetlist_id' => $request->packetlist_id[$key],
                        'packetlist_detail_id' => $request->size_id[$key],
                        'length_id' => $request->length_id[$key],
                        'rate' => $request->rate[$key],
                        'quantity' => $request->quantity[$key],
                    ]);
            }
        }

        $data = [
            'customer_id' => $request->get('customer_id'),
            'customer_bill_id' => $customer_bill->id,
            'debit' => $total
        ];

        CustomerAccount::where('customer_bill_id',$request->id)->update($data);

        return redirect()->route('customer_bills')
            ->with('success','Customer Bill updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        CustomerBill::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }

    public function customer_bill_detail(Request $request){
        $customerBillDetail = CustomerBillDetail::leftjoin('warehouses','warehouses.id','=','customer_bill_details.warehouse_id')
            ->leftjoin('stock_lists','stock_lists.id','=','customer_bill_details.stocklist_id')
            ->leftjoin('packet_lists','packet_lists.id','=','customer_bill_details.packetlist_id')
            ->leftjoin('packet_list_details','packet_list_details.id','=','customer_bill_details.packetlist_detail_id')
            ->leftjoin('lengths','lengths.id','=','customer_bill_details.length_id')
            ->where('customer_bill_details.customer_bill_id', $request->customer_bill_id)->where('customer_bill_details.is_deleted', 0)
            ->select('customer_bill_details.*','warehouses.name as warehouse_name','stock_lists.container_number as container_name','packet_lists.description as packet_name','packet_list_details.size as packet_list_size','lengths.length')
            ->get();
        echo json_encode(["customer_bill_detail" => $customerBillDetail]);
        exit();
    }

    public function remove_single_customer_bill(Request $request)
    {
//        dd($request->all());
        CustomerBillDetail::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);

        $customer_bill_detail = CustomerBillDetail::find($request->id);
        $total = $customer_bill_detail->rate * $customer_bill_detail->quantity;

        $customer_bill = CustomerBill::find($request->customer_bill_id);
        $customer_bill->total -= $total;
        $customer_bill->save();

        $customer_bill_account = CustomerAccount::where('customer_bill_id',$request->customer_bill_id)->first();
        $customer_bill_account->debit -= $total;
        $customer_bill_account->save();

        echo json_encode([
            'success' => true
        ]);
    }
}
