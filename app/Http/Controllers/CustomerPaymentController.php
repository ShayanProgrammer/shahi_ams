<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\CustomerPayment;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{
    public function index()
    {
        $customer_payments = CustomerPayment::latest()->paginate(10);
        return view('customer_payments.index', compact('customer_payments'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function customer_payment_list(Request $request)
    {
        try {
            $query = DB::table('customer_payments')
                ->leftjoin('customers', 'customers.id', '=', 'customer_payments.customer_id')
                ->leftjoin('payment_types', 'payment_types.id', '=', 'customer_payments.payment_type_id')
                ->select('customer_payments.*', 'customers.name as customer_name', 'payment_types.name as payment_type_name');
//            if (isset($request->company) && !empty($request->company)) {
//                $query->where('customer_payments.company_id', '=', $request->company);
//            }
            $customer_payments = $query->where('customer_payments.is_deleted', 0)->get();

            echo json_encode([
                'customer_payments' => $customer_payments
            ]);
            exit;
        } catch (\Exception $ex) {
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
        $payment_types = PaymentType::where('is_deleted', 0)->get();
        $banks = Bank::where('is_deleted', 0)->get();
        return view('customer_payments.create', compact('customers','payment_types', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'customer_id' => 'required',
            'amount' => 'required',
            'payment_type_id' => 'required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $save_array = [
            'customer_id'=> $request->get('customer_id'),
            'amount'=> $request->get('amount'),
            'payment_type_id'=> $request->get('payment_type_id'),
            'cheque_no'=> $request->get('cheque_no'),
            'bank_id' => $request->get('bank'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ];

        $customer_payment = new CustomerPayment($save_array);

        $customer_payment->save();


        if($request->get('payment_type_id') == 3 || $request->get('payment_type_id') == 4) {
            $bank_account = new BankAccount();
            if($request->get('payment_type_id') == 3) {
                $bank_account->cheque_no = $request->get('cheque_no');
                $bank_account->bank_id = $request->get('bank');
            } else {
                $bank_account->bank_id = $request->get('bank');
            }
            $bank_account->customer_payment_id = $customer_payment->id;
            $bank_account->debit = $request->get('amount');
            $bank_account->save();
        }


        $customer_account = new CustomerAccount([
            'customer_id' => $request->get('customer_id'),
            'paid_payment' => 'Received',
            'bank_id'=> $request->get('bank'),
            'cheque_no'=> $request->get('cheque_no'),
            'credit' => $request->get('amount')
        ]);

        $customer_account->save();

        return redirect()->route('customer_payments')
            ->with('success', 'CustomerPayment created successfully.');
    }

    public function edit($id)
    {
        $customer_payment = CustomerPayment::where('id', $id)->first();
        $customers = Customer::where('is_deleted', 0)->get();
        $payment_types = PaymentType::where('is_deleted', 0)->get();
        $banks = Bank::where('is_deleted', 0)->get();
        return view('customer_payments.edit', compact('banks','customer_payment', 'customers','payment_types'));
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
        $this->validate($request, [
            'customer_id' => 'required',
            'amount' => 'required',
            'payment_type_id' => 'required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        CustomerPayment::where('id', $request->id)
            ->update([
                'customer_id' => $request->customer_id,
                'amount' => $request->amount,
                'payment_type_id' => $request->payment_type_id,
                'cheque_no' => $request->cheque_no,
                'bank_id' => $request->bank,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        if($request->get('payment_type_id') == 3 || $request->get('payment_type_id') == 4) {
            $bank_account = BankAccount::where('customer_payment_id',$request->id)->first();
            if($request->get('payment_type_id') == 3) {
                $bank_account->cheque_no = $request->get('cheque_no');
                $bank_account->bank_id = $request->get('bank');
            } else {
                $bank_account->bank_id = $request->get('bank');
            }
            $bank_account->customer_payment_id = $request->id;
            $bank_account->debit = $request->amount;
            $bank_account->save();
        }

        return redirect()->route('customer_payments')
            ->with('success', 'Customer Payment updated successfully');
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

        CustomerPayment::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
