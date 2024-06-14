<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\Actions\AccountPaymentService;
use Illuminate\Http\Request;
use App\Models\{Company,CompanyAccount,ImportStatus,AccountPayment};
use Session;

class AccountPaymentController extends Controller
{
    use AccountPaymentService;
    /**
     * Display a View of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importstatuses = AccountPayment::latest()->paginate(10);
        return view('account_payments.index', compact('importstatuses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $query = DB::table('account_payments')
                ->leftjoin('companies', 'companies.id', '=', 'account_payments.company_id')
                ->select('account_payments.*', 'companies.name as company_name');

            if (isset($request->company) && !empty($request->company)) {
                $query->where('account_payments.company_id', '=', $request->company);
            }

            $account_payments = $query->where('account_payments.is_deleted', 0)->get();

            echo json_encode([
                'account_payments' => $account_payments
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
    public function create($company_id)
    {
        $companies = Company::where('is_deleted', 0)->get();
        $company = Company::where('id', $company_id)->first();
        return view('account_payments.create', compact('companies','company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Add column to company_accounts
    // ALTER TABLE `u701666151_shahi_db`.`company_accounts` ADD COLUMN `account_payment_id` INT NULL AFTER `import_status_id`;
    public function store(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'description' => 'required'
        ], [
            'total.required' => 'Amount is required',
            'description.required' => 'Description is required',
        ]);

        $company_id     = $request->get('company_id');
        $description    = $request->get('description');
        $total_amount   = (int)($request->get('total')??0);


        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        //New Account Payment
        $account_payment = new AccountPayment([
            'company_id' => $request->get('company_id'),
            'total' => $request->get('total'),
            'description' => $request->get('description'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);
        $account_payment->save();

        // Check if company_account(using company_id) does not exists for import status else create new company_account else adjust to new value new company acccount for same company account.
        // check if total_account = positive,then save payable else if total_account = negative then save receivable
        if (!$this->exists_company_account($company_id)) {
            $save_array = [
                'company_id'=> $company_id,
                'account_payment_id'=> $account_payment->id,
                'description'=> $description,
                'value'=> $total_amount??0,
                'payable'=> $total_amount >= 0 ? $total_amount: null,
                'receivable'=> $total_amount < 0 ? $total_amount: null,
                'payment'=> $total_amount??0,
            ];
            $company_account = new CompanyAccount($save_array);
            $company_account->save();
            return redirect()->route('accountpayments.index')
                ->with('success', 'Account Payment created successfully.');
        }

        // else new_value_for_new_company_account = total_amount + value(most_recent_company_value)
        $recent_value_adjusted_account = $this->most_recent_company_value($company_id) - $total_amount;

        $save_array = [
            'company_id'=> $company_id,
            'account_payment_id'=> $account_payment->id,
            'description'=> $description,
            'value'=> $recent_value_adjusted_account??0,
            //check if recent_value_adjusted_account is positive,then save payable
            'payable'=> ($recent_value_adjusted_account >= 0 ) ? $recent_value_adjusted_account: null,
            //check if recent_value_adjusted_account is negative,then save receiveable
            'receivable'=> ($recent_value_adjusted_account < 0 ) ? $recent_value_adjusted_account: null,
            'payment'   => $total_amount
        ];

        $company_account = new CompanyAccount($save_array);
        $company_account->save();
        // return redirect()->route('accountpayments.index')
        //     ->with('success', 'Account Payment created successfully.');

        return back()->with('success', 'Account Payment created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \IlluminateHttp\Response
     */
    public function show(ImportStatus $importstatus)
    {
        return view('importstatuses.show', compact('importstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $importstatus = ImportStatus::where('id', $id)->first();
        $companies = Company::where('is_deleted', 0)->get();
        return view('importstatuses.edit', compact('importstatus', 'companies'));
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
        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $this->validate($request, [
            'company_id' => 'required',
            'performa' => 'required',
            'rate' => 'required',
            'description' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'length' => 'required',
            'date' => 'required'
        ]);

        ImportStatus::where('id', $request->id)
            ->update([
                'company_id' => $request->company_id,
                'performa' => $request->performa,
                'rate' => $request->rate,
                'description' => $request->description,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'length' => $request->length,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('importstatuses')
            ->with('success', 'Import Status updated successfully');
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

        ImportStatus::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
        echo json_encode(['message' => 'Deleted successfully']);
    }
}
