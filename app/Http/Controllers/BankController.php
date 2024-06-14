<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use DB;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::latest()->paginate(10);
        return view('banks.index',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function bank_list(Request $request){
        try{
            $query = DB::table('banks');

            $banks = $query->where('is_deleted',0)->get();

            echo json_encode([
                'banks' => $banks
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
        return view('banks.create');
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
        ], [
            'name.required' => 'Bank name is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $bank = new Bank([
            'name' => $request->get('name'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $bank->save();

        return redirect()->route('banks')
            ->with('success','Bank created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return view('banks.show',compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $bank = Bank::where('id',$id)->first();
        return view('banks.edit',compact('bank'));
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
            'name' => 'required'
        ], [
            'name.required' => 'Bank name is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        Bank::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('banks')
            ->with('success','Bank updated successfully');
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

        Bank::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);

        echo json_encode(['message' => 'Deleted successfully']);
    }

    public function bank_account($id)
    {
//         dd('test');
        $bank_accounts = BankAccount::where('bank_id', $id)->where('is_deleted',0)->get();
//        dd($bank_accounts);
        return view('bank_accounts.index',compact('bank_accounts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function bank_account_list(Request $request){
        try{

            $query = DB::table('bank_accounts')->leftjoin('import_duties','import_duties.id','=','bank_accounts.import_duty_id')
                ->leftjoin('customer_bills','customer_bills.id','=','bank_accounts.customer_bill_id')
                ->leftjoin('customer_payments','customer_payments.id','=','bank_accounts.customer_payment_id')
                ->leftjoin('customers','customers.id','=','customer_payments.customer_id');

            $bank_accounts = $query->where('bank_accounts.bank_id',$request->bank_id)
                ->where('bank_accounts.is_deleted',0)
                ->select('bank_accounts.*','import_duties.performa as import_duty_performa','customers.name as customer_name','customer_bills.invoice_number')
                ->get();

            echo json_encode([
                'bank_accounts' => $bank_accounts
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }

    public function delete_bank_account(Request $request)
    {
        BankAccount::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode(['message' => 'Deleted successfully']);
    }
}
