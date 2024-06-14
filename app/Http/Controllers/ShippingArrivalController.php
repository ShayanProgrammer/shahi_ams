<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ImportStatus;
use App\Models\ShippingArrival;
use App\Models\ShippingArrivalDetail;
use DB;
use Illuminate\Http\Request;

class ShippingArrivalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping_arrivals = ShippingArrival::latest()->paginate(10);
        return view('shipping_arrivals.index',compact('shipping_arrivals'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function arrived_shipping()
    {
        $shipping_arrivals = ShippingArrival::latest()->paginate(10);
        return view('shipping_arrivals.arrived_shipping',compact('shipping_arrivals'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function shipping_arrival_list(Request $request){
        try{
            $query = DB::table('shipping_arrivals')
                ->leftjoin('companies', 'companies.id', '=', 'shipping_arrivals.company_id')
                ->leftjoin('import_statuses','import_statuses.id','=','shipping_arrivals.import_status_id')
                ->select('shipping_arrivals.*', 'companies.name as company_name','import_statuses.performa');

            if (isset($request->company) && !empty($request->company)) {
                $query->where('shipping_arrivals.company_id', '=', $request->company);
            }

            $shipping_arrivals = $query->where('shipping_arrivals.is_deleted',0)->get();

            echo json_encode([
                'shipping_arrivals' => $shipping_arrivals
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
        $importstatuses = ImportStatus::where('is_deleted',0)->get();
        return view('shipping_arrivals.create',compact('companies','importstatuses'));
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
            'company_id' => 'required',
            'item_description' => 'required',
            'no_of_container' => 'required',
            'arrival_date' => 'required'
        ], [
            'company_id.required' => 'Company is required',
            'item_description.required' => 'Item description is required',
            'no_of_container.required' => 'Number of container is required',
            'arrival_date.required' => 'Arrival date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $shipping_arrival = new ShippingArrival([
            'company_id' => $request->get('company_id'),
            'item_description' => $request->get('item_description'),
            'no_of_container' => $request->get('no_of_container'),
            'bl_tracking' => $request->get('bl_tracking'),
            'port_name' => $request->get('port_name'),
            'import_status_id' => $request->get('import_status_id'),
            'arrival_date' => $request->get('arrival_date'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ]);

        $shipping_arrival->save();

//        dd($shipping_arrival);
        foreach ($request->container_number as $key => $value) {
            $shipping_arrival_array[] = [
                'shipping_arrival_id' => $shipping_arrival->id,
                'container_number' => $value,
            ];
        }

        ShippingArrivalDetail::insert($shipping_arrival_array);

        return redirect()->route('shipping_arrivals')
            ->with('success','Shipping Arrival created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingArrival $shipping_arrival)
    {
        return view('shipping_arrivals.show',compact('shipping_arrival'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $shipping_arrival = ShippingArrival::where('id',$id)->where('is_deleted',0)->first();

        $shipping_arrival_details = DB::table('shipping_arrival_details')
            ->where('shipping_arrival_id', $id)
            ->where('is_deleted', 0)
            ->get();

        $companies = Company::where('is_deleted', 0)->get();

        $importstatuses = ImportStatus::where('company_id',$shipping_arrival->company_id)->where('is_deleted',0)->get();

        return view('shipping_arrivals.edit',compact('shipping_arrival','shipping_arrival_details','companies','importstatuses'));
    }

    public function shipping_arrival_detail(Request $request){
        $shippingArrivalDetail = ShippingArrivalDetail::where('shipping_arrival_id', $request->shipping_arrival_id)->where('is_arrived',0)->where('is_deleted', 0)->get();
        echo json_encode(["shipping_arrival_detail" => $shippingArrivalDetail]);
        exit();
    }

    public function shipping_arrived_detail(Request $request){
        $shippingArrivalDetail = ShippingArrivalDetail::where('shipping_arrival_id', $request->shipping_arrival_id)->where('is_arrived',1)->where('is_deleted', 0)->get();
        echo json_encode(["shipping_arrival_detail" => $shippingArrivalDetail]);
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

        $this->validate($request,[
            'company_id' => 'required',
            'item_description' => 'required',
            'no_of_container' => 'required',
            'arrival_date' => 'required'
        ], [
            'company_id.required' => 'Company is required',
            'item_description.required' => 'Item description is required',
            'no_of_container.required' => 'Number of container is required',
            'arrival_date.required' => 'Arrival date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        ShippingArrival::where('id', $request->id)
            ->update([
                'company_id' => $request->company_id,
                'item_description' => $request->item_description,
                'no_of_container' => $request->no_of_container,
                'bl_tracking' => $request->bl_tracking,
                'port_name' => $request->port_name,
                'import_status_id' => $request->import_status_id,
                'arrival_date' => $request->arrival_date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        for($i = 0; $i < count($request->container_number); $i++) {
            $shipping_arrival_array[] = [
                'id' => $request->shipping_arrival_detail_id[$i],
                'shipping_arrival_id' => $request->id,
                'container_number' => $request->container_number[$i],
            ];
        }

        foreach($shipping_arrival_array as $detail_array) {
            if($detail_array['id'] == null) {
                ShippingArrivalDetail::insert($detail_array);
            } else {
                ShippingArrivalDetail::where('id', $detail_array['id'])
                    ->update([
                        'container_number' => $detail_array['container_number']
                    ]);
            }
        }

        return redirect()->route('shipping_arrivals')
            ->with('success','Shipping Arrival updated successfully');
    }

    public function remove_single_shipping_arrival(Request $request)
    {
        ShippingArrivalDetail::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode([
            'success' => true
        ]);
    }

    public function update_shipping_arrival_arrived(Request $request)
    {
        $id = $request->id;
        $is_arrived = $request->is_arrived;
        if($is_arrived == "true") {
            ShippingArrivalDetail::where('id', $id)
                ->update([
                    'is_arrived' => 1
                ]);
        } else {
            ShippingArrivalDetail::where('id', $id)
                ->update([
                    'is_arrived' => 0
                ]);
        }
        echo json_encode([
            'success' => true
        ]);
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

        ShippingArrival::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }
}
