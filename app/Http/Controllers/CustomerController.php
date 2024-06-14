<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAccount;
use DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index',compact('customers'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function customer_account()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.customer_account',compact('customers'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function delete_customer_account(Request $request)
    {
        CustomerAccount::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode(['message' => 'Deleted successfully']);
    }



    public function customer_account_list(Request $request){
        try{
            $query = DB::table('customer_accounts')
            ->leftjoin('customer_bills','customer_bills.id','=','customer_accounts.customer_bill_id')
            ->select('customer_accounts.*','customer_bills.invoice_number');

            $customer_accounts = $query->where('customer_accounts.customer_id',$request->customer)->where('customer_accounts.is_deleted',0)->get();

//            dd($customer_accounts);

            echo json_encode([
                'customer_accounts' => $customer_accounts
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }

    public function customer_list(Request $request){
        try{
            $query = DB::table('customers');

            $customers = $query->where('is_deleted',0)->get();

            echo json_encode([
                'customers' => $customers
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
        return view('customers.create');
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
            'name' => 'required',
            'phone' => 'required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $customer = new Customer([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $customer->save();

        return redirect()->route('customers')
            ->with('success','Customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $customer = Customer::where('id',$id)->first();
        return view('customers.edit',compact('customer'));
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

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        Customer::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('customers')
            ->with('success','Customer updated successfully');
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

        Customer::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
