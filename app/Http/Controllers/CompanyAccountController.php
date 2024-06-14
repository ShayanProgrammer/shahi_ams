<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyAccount;
use DB;
use Illuminate\Http\Request;
use Session;

class CompanyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {
        $company_accounts = CompanyAccount::where('company_id',$company_id)->where('is_deleted',0)->get();
        $company = Company::where('id',$company_id)->first();
        Session::put('company_id', $company_id);
        return view('company_accounts.index',compact('company_accounts','company'));
    }

    public function company_account_list(Request $request){

        try{

            $query = DB::table('company_accounts');

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

            $company_accounts = $query->where('company_id',$request->company)->where('is_deleted',0)->orderBy('id','desc')->get();

//            dd($company_accounts);

            echo json_encode([
                'company_accounts' => $company_accounts
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
        return view('companies.create');
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
            'name.required' => 'Company name is required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $company = new Company([
            'name' => $request->get('name'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $company->save();

        return redirect()->route('companies')
            ->with('success','Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $company = Company::where('id',$id)->first();
        return view('companies.edit',compact('company'));
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
            'name.required' => 'Company name is required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        Company::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('companies')
            ->with('success','Company updated successfully');
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

        Company::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }

    public function delete_company_account(Request $request)
    {
//        dd($request->all());
        $id = $request->get('id');
        $account_id = $request->get('account_id');
        $payment = $request->get('payment');
        $company_id = $request->get('company_id');

        CompanyAccount::where('id', $id)
            ->update([
                'is_deleted' => 1
            ]);

        $company_account = CompanyAccount::where('company_id', $company_id)->where('id', '>', $id)->where('is_deleted',0)->get();

        foreach($company_account as $data) {
            CompanyAccount::where('id', $data->id)
                ->update([
                    'value' =>  $data->value + $payment,
                    'payable' =>  $data->payable + $payment,
                ]);
        }

        echo json_encode(['message' => 'Deleted successfully']);
    }
}
