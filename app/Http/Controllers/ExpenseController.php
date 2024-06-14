<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use DB;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('expenses.index',compact('expenses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function expense_list(Request $request){

        try{
            $query = DB::table('expenses');

            if(isset($request->from_date) && !empty($request->from_date)){

                $query->where('date', '>=', $request->from_date);
            }
            if(isset($request->to_date) && !empty($request->to_date)){
                $query->where('date', '<=', $request->to_date);
            }

            $expenses = $query->where('is_deleted',0)->get();

            echo json_encode([
                'expenses' => $expenses
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
        return view('expenses.create');
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
            'description' => 'required',
            'amount' => 'required',
            'date' => 'required'
        ], [
            'description.required' => 'Description is required',
            'amount.required' => 'Amount is required',
            'date.required' => 'Date is required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $expense = new Expense([
            'description' => $request->get('description'),
            'amount' => $request->get('amount'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
            'date' => date("d-m-Y", strtotime($request->get('date')))
        ]);

        $expense->save();

        return redirect()->route('expenses')
            ->with('success','Expense created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('expenses.show',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::where('id',$id)->first();
        return view('expenses.edit',compact('expense'));
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
            'description' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ], [
            'description.required' => 'Description is required',
            'amount.required' => 'Amount is required',
            'date.required' => 'Date is required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        Expense::where('id', $request->id)
            ->update([
                'description' => $request->description,
                'amount' => $request->amount,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('expenses')
            ->with('success','Expense updated successfully');
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

        Expense::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
