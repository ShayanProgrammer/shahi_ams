<?php

namespace App\Http\Controllers;

use DB;
use App\Actions\CompanyAccountService;
use Illuminate\Http\Request;
use App\Models\{Company, CompanyAccount, ImportStatus, ImportStatusDetail};

class ImportStatusController extends Controller
{
    use CompanyAccountService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importstatuses = ImportStatus::latest()->paginate(10);
        return view('importstatuses.index', compact('importstatuses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function company_importstatuses()
    {
        $importstatuses = ImportStatus::latest()->paginate(10);
        return view('importstatuses.index', compact('importstatuses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function importstatus_list(Request $request)
    {
        try {
            $query = DB::table('import_statuses')
                ->leftjoin('companies', 'companies.id', '=', 'import_statuses.company_id')
                ->select('import_statuses.*', 'companies.name as company_name');

            if (isset($request->company) && !empty($request->company)) {
                $query->where('import_statuses.company_id', '=', $request->company);
            }

            $importstatuses = $query->where('import_statuses.is_deleted', 0)->get();

            echo json_encode([
                'importstatuses' => $importstatuses
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
        $companies = Company::where('is_deleted', 0)->get();
        return view('importstatuses.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         dd($request->all());

        $this->validate($request, [
            'company_id' => 'required',
            'performa' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $company_id     = $request->get('company_id') ?? 0;
        $description    = $request->get('description');

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        //New import status
        $importstatus = new ImportStatus([
            'company_id' => $request->get('company_id'),
            'performa' => $request->get('performa'),
            'description' => $request->get('description'),
            'date' => $request->get('date'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

//        dd($importstatus);

        $importstatus->save();

        foreach ($request->rate as $key => $value) {
            $importstatus_detail_array[] = [
                'import_status_id' => $importstatus->id,
                'rate' => $value,
                'quantity' => $request->quantity[$key],
                'length' => $request->length[$key],
                'size' => $request->size[$key],
            ];
        }

        ImportStatusDetail::insert($importstatus_detail_array);
//
//        $importstatus_detail = ImportStatusDetail::where('importstatus_id',$importstatus->id)->where('is_deleted',0)->get();
//
        $total_amount = ImportStatusDetail::where('import_status_id', $importstatus->id)
            ->where('is_deleted', 0)
            ->sum(\DB::raw('quantity * rate'));
//        dd($total);



        //total_amount = quantity * rate
//        $total_amount = (int)((int)$request->get('quantity') * (int)$request->get('rate'));
        if (!$this->exists_company_account($company_id)) {
            $save_array = [
                'company_id'=> $company_id,
                'import_status_id'=> $importstatus->id,
                'account_payment_id'=> 0,
                'description'=> $description,
                'total'=> $total_amount??0,
                'value'=> $total_amount??0,
                'payable'=> $total_amount >= 0 ? $total_amount: null,
                'receivable'=> $total_amount < 0 ? $total_amount: null
            ];
            $company_account = new CompanyAccount($save_array);
            $company_account->save();
            return redirect()->route('importstatuses')
            ->with('success', 'ImportStatus created successfully.');
        }

        //else new_value_for_new_company_account = value(most_recent_company_value) + total_amount
        $recent_value_company_account = $this->most_recent_company_value($company_id) + $total_amount;

        $save_array = [
            'company_id'=> $company_id,
            'import_status_id'=> $importstatus->id,
            'account_payment_id'=> 0,
            'description'=> $description,
            'total'=> $total_amount??0,
            'value'=> $recent_value_company_account??0,
            //check if recent_value_company_account is positive,then save payable
            'payable'=> ($recent_value_company_account >= 0 ) ? $recent_value_company_account: null,
            //check if recent_value_company_account is negative,then save receiveable
            'receivable'=> ($recent_value_company_account < 0 ) ? $recent_value_company_account: null
        ];

        $company_account = new CompanyAccount($save_array);
        $company_account->save();
        return redirect()->route('importstatuses')
            ->with('success', 'ImportStatus created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ImportStatus $importstatus)
    {
        return view('importstatuses.show', compact('importstatus'));
    }

    /**x
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $importstatus = DB::table('import_statuses')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        $importstatus_details = DB::table('import_status_details')
            ->where('import_status_id', $id)
            ->where('is_deleted', 0)
            ->get();

//        dd($importstatus_details);
        $companies = Company::where('is_deleted', 0)->get();
        return view('importstatuses.edit', compact('importstatus', 'companies','importstatus_details'));
    }

    public function import_status_detail(Request $request){
        $importStatusDetail = ImportStatusDetail::where('import_status_id', $request->import_status_id)->where('is_deleted', 0)->get();
        echo json_encode(["import_status_detail" => $importStatusDetail]);
        exit();
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
            'company_id' => 'required',
            'performa' => 'required',
            // 'rate' => 'required',
            'description' => 'required',
            // 'size' => 'required',
            // 'quantity' => 'required',
            // 'length' => 'required',
            'date' => 'required'
        ], [
            'company_id.required' => 'Select the company from company list option',
            'performa.required' => 'Performa is required',
            'description.required' => 'Description is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        ImportStatus::where('id', $request->id)
            ->update([
                'company_id' => $request->company_id,
                'performa' => $request->performa,
                'description' => $request->description,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);


//        dd($request->rate[1]);
        for($i = 0; $i < count($request->rate); $i++) {
            $importstatus_detail_array[] = [
                'id' => $request->import_status_detail_id[$i],
                'import_status_id' => $request->id,
                'rate' => $request->rate[$i],
                'quantity' => $request->quantity[$i],
                'length' => $request->length[$i],
                'size' => $request->size[$i],
            ];
        }



        foreach($importstatus_detail_array as $detail_array) {
            if($detail_array['id'] == null) {
                ImportStatusDetail::insert($detail_array);
            } else {
                ImportStatusDetail::where('id', $detail_array['id'])
                    ->update([
                        'rate' => $detail_array['rate'],
                        'quantity' => $detail_array['quantity'],
                        'length' => $detail_array['length'],
                        'size' => $detail_array['size']
                    ]);

            $total_amount = ImportStatusDetail::where('import_status_id', $detail_array['import_status_id'])
            ->where('is_deleted', 0)
            ->sum(\DB::raw('quantity * rate'));

            CompanyAccount::where('import_status_id', $detail_array['import_status_id'])
                ->update([
                    'total'=> $total_amount??0,
                    'value'=> $total_amount??0,
                    'payable'=> $total_amount >= 0 ? $total_amount: null,
                    'receivable'=> $total_amount < 0 ? $total_amount: null
                ]);

            }
        }

//        dd($importstatus_detail_array);


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

    public function remove_single_importstatus(Request $request)
    {
        ImportStatusDetail::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode([
            'success' => true
        ]);
    }
}
