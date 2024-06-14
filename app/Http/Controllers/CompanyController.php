<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ImportStatus;
use App\Models\Status;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('companies.index',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    public function company_list(Request $request){
        try{
            $query = DB::table('companies')->join('status','status.id','=','companies.status_id')->select('companies.*','status.status');

            $companies = $query->where('companies.is_deleted', 0)->where('companies.status_id','!=', '3')->get();

            echo json_encode([
                'companies' => $companies
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
            'name.required' => 'Company Name is required',
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
            'name.required' => 'Company Name is required',
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
}
