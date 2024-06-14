<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\ImportDuties;
use DB;
use Illuminate\Http\Request;

class ImportDutiesController extends Controller
{
    public function index()
    {
        $importduties = ImportDuties::latest()->paginate(10);
//        dd($importduties);
        return view('importduties.index',compact('importduties'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function bank_importduties()
    {
        $importduties = ImportDuties::latest()->paginate(10);
        return view('importduties.index',compact('importduties'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function importduty_list(Request $request){
        try{
            $query = DB::table('import_duties')
                ->leftjoin('banks','banks.id','=','import_duties.bank_id')
                ->select('import_duties.*','banks.name as bank_name');

            if(isset($request->bank) && !empty($request->bank)){
                $query->where('import_duties.bank_id', '=', $request->bank);
            }

            $importduties = $query->where('import_duties.is_deleted',0)->get();



            echo json_encode([
                'importduties' => $importduties
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
        $banks = Bank::where('is_deleted',0)->get();
        return view('importduties.create',compact('banks'));
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
            'bank_id' => 'required',
            'check' => 'required',
            'payorder' => 'required',
            'performa' => 'required',
            'amount' => 'required',
            'no_of_container' => 'required',
            'date' => 'required'
        ], [
            'bank_id.required' => 'Select the bank from bank list option',
            'check.required' => 'Check Number is required',
            'payorder.required' => 'Payorder is required',
            'performa.required' => 'Performa is required',
            'amount.required' => 'Amount is required',
            'no_of_container.required' => 'No of container is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $importduty = new ImportDuties([
            'bank_id' => $request->get('bank_id'),
            'check' => $request->get('check'),
            'payorder' => $request->get('payorder'),
            'performa' => $request->get('performa'),
            'amount' => $request->get('amount'),
            'no_of_container' => $request->get('no_of_container'),
            'date' => $request->get('date'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $importduty->save();

        $bank_account = new BankAccount();
        $bank_account->import_duty_id = $importduty->id;
        $bank_account->bank_id = $request->get('bank_id');
        $bank_account->credit = $request->get('amount');
        $bank_account->save();

        return redirect()->route('importduties')
            ->with('success','ImportDuties created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ImportDuties $importduty)
    {
        return view('importduties.show',compact('importduty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $importduty = ImportDuties::where('id',$id)->first();
        $banks = Bank::where('is_deleted',0)->get();
        return view('importduties.edit',compact('importduty','banks'));
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
            'bank_id' => 'required',
            'check' => 'required',
            'payorder' => 'required',
            'performa' => 'required',
            'amount' => 'required',
            'no_of_container' => 'required',
            'date' => 'required'
        ], [
            'bank_id.required' => 'Select the bank from bank list option',
            'check.required' => 'Check Number is required',
            'payorder.required' => 'Payorder is required',
            'performa.required' => 'Performa is required',
            'amount.required' => 'Amount is required',
            'no_of_container.required' => 'No of container is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        ImportDuties::where('id', $request->id)
            ->update([
                'bank_id' => $request->bank_id,
                'check' => $request->check,
                'payorder' => $request->payorder,
                'performa' => $request->performa,
                'amount' => $request->amount,
                'no_of_container' => $request->no_of_container,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        $bank_account = BankAccount::where('import_duty_id',$request->id)->first();
        $bank_account->credit = $request->amount;
        $bank_account->save();

        return redirect()->route('importduties')
            ->with('success','Import Duty updated successfully');
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

        ImportDuties::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
