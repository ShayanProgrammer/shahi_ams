<?php

namespace App\Http\Controllers;

use App\Models\ClearingAgent;
use App\Models\ClearingAgentAccount;
use App\Models\ShippingArrival;
use DB;
use Illuminate\Http\Request;

class ClearingAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clearing_agents = ClearingAgent::latest()->paginate(10);
        return view('clearing_agents.index',compact('clearing_agents'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function clearing_agent_list(Request $request){
        try{
            $query = DB::table('clearing_agents');

            $clearing_agents = $query->where('is_deleted',0)->get();

            echo json_encode([
                'clearing_agents' => $clearing_agents
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
        return view('clearing_agents.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClearingAgent $clearing_agent)
    {
        return view('clearing_agents.show',compact('clearing_agent'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $clearing_agent = new ClearingAgent([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $clearing_agent->save();

        return redirect()->route('clearing_agents')
            ->with('success','ClearingAgent created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_account(ClearingAgent $clearing_agent)
    {
        return view('clearing_agents.show',compact('clearing_agent'));
    }


    public function edit($id){
        $clearing_agent = ClearingAgent::where('id',$id)->first();
        return view('clearing_agents.edit',compact('clearing_agent'));
    }


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

        ClearingAgent::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('clearing_agents')
            ->with('success','ClearingAgent updated successfully');
    }


    public function delete(Request $request)
    {
        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        ClearingAgent::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }

    public function clearing_agent_account($id)
    {
//         dd('test');
        $clearing_agent_accounts = ClearingAgentAccount::where('clearing_agent_id', $id)->where('is_deleted',0)->get();
//        dd($clearing_agent_accounts);
        return view('clearing_agent_accounts.index',compact('clearing_agent_accounts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    public function clearing_agent_account_list(Request $request){
        try{

            $query = DB::table('clearing_agent_accounts');

            $clearing_agent_accounts = $query->where('clearing_agent_id',$request->clearing_agent_id)->where('is_deleted',0)->get();

            echo json_encode([
                'clearing_agent_accounts' => $clearing_agent_accounts
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }

    public function create_clearing_agent_account()
    {
        $bl_numbers = ShippingArrival::where('is_deleted',0)->select('bl_tracking')->get();
        return view('clearing_agent_accounts.create',compact('bl_numbers'));
    }

    public function store_clearing_agent_account(Request $request)
    {
        $this->validate($request, [
            'bl_no' => 'required',
            'bill_no' => 'required',
            'no_of_container' => 'required',
            'description' => 'required',
            'date' => 'required',
//            'debit' => 'required',
//            'credit' => 'required'
        ], [
            'bl_no.required' => 'BL number is required',
            'bill_no.required' => 'Bill number is required',
            'no_of_container.required' => 'Number of container is required',
            'description.required' => 'Description is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $clearing_agent = new ClearingAgentAccount([
            'clearing_agent_id' => \Request::segment(2),
            'bl_no' => $request->get('bl_no'),
            'bill_no' => $request->get('bill_no'),
            'no_of_container' => $request->get('no_of_container'),
            'description' => $request->get('description'),
            'date' => $request->get('date'),
            'debit' => $request->get('debit'),
            'credit' => $request->get('credit'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
        ]);

        $clearing_agent->save();

        return redirect()->back()->with('success', 'Clearing Agent Account created successfully.');
    }

    public function edit_clearing_agent_account($id){
        $clearing_agent = ClearingAgentAccount::where('id',$id)->first();
        $bl_numbers = ShippingArrival::where('is_deleted',0)->select('bl_tracking')->get();
        return view('clearing_agent_accounts.edit',compact('clearing_agent','bl_numbers'));
    }

    public function update_clearing_agent_account(Request $request)
    {

        $this->validate($request,[
            'bl_no' => 'required',
            'bill_no' => 'required',
            'no_of_container' => 'required',
            'description' => 'required',
            'date' => 'required',
//            'debit' => 'required',
//            'credit' => 'required'
        ], [
            'bl_no.required' => 'BL number is required',
            'bill_no.required' => 'Bill number is required',
            'no_of_container.required' => 'Number of container is required',
            'description.required' => 'Description is required',
            'date.required' => 'Date is required',
        ]);

        ClearingAgentAccount::where('id', $request->id)
            ->update([
                'bl_no' => $request->bl_no,
                'bill_no' => $request->bill_no,
                'no_of_container' => $request->no_of_container,
                'description' => $request->description,
                'date' => $request->date,
                'debit' => $request->debit,
                'credit' => $request->credit
            ]);

        return redirect()->back()->with('success','Clearing Agent updated successfully');
    }

    public function delete_clearing_agent_account(Request $request)
    {
        ClearingAgentAccount::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode(['message' => 'Deleted successfully']);
    }
}
