<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index',compact('warehouses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function warehouse_list(Request $request){
        try{
            $query = DB::table('warehouses');

            $warehouses = $query->where('is_deleted',0)->get();

            echo json_encode([
                'warehouses' => $warehouses
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
        return view('warehouses.create');
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
            'name.required' => 'Warehouse name is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $warehouse = new Warehouse([
            'name' => $request->get('name'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $warehouse->save();

        return redirect()->route('warehouses')
            ->with('success','Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        return view('warehouses.show',compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $warehouse = Warehouse::where('id',$id)->first();
        return view('warehouses.edit',compact('warehouse'));
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
            'name.required' => 'Warehouse name is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        Warehouse::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        return redirect()->route('warehouses')
            ->with('success','Warehouse updated successfully');
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

        Warehouse::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
