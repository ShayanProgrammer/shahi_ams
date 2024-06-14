<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PacketList;
use App\Models\PacketListDetail;
use App\Models\StockList;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;

class StockListController extends Controller
{
    public function index()
    {
        $stocklists = StockList::latest()->paginate(10);
        return view('stocklists.index', compact('stocklists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function warehouse_stocklists()
    {
        $stocklists = StockList::latest()->paginate(10);
        return view('stocklists.index', compact('stocklists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function stocklist_list(Request $request)
    {
        try {
            $query = DB::table('stock_lists')
                ->leftjoin('companies', 'companies.id', '=', 'stock_lists.company_id')
                ->leftjoin('warehouses', 'warehouses.id', '=', 'stock_lists.warehouse_id')
                ->leftjoin('packet_lists', 'packet_lists.stock_list_id', '=', 'stock_lists.id')
                ->select('stock_lists.*', 'companies.name as company_name', 'warehouses.name as warehouse_name', 'packet_lists.description' ,'packet_lists.id as packet_list_id');
            if (isset($request->company) && !empty($request->company)) {
                $query->where('stock_lists.company_id', '=', $request->company);
            }
            $stocklists = $query->where('stock_lists.is_deleted', 0)->get();

            echo json_encode([
                'stocklists' => $stocklists
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
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        return view('stocklists.create', compact('companies','warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'company_id' => 'required',
            'warehouse_id' => 'required',
            'container_number' => 'required',
            'no_of_packets' => 'required',
            'date' => 'required'
        ], [
            'company_id.required' => 'Select company from company list option',
            'warehouse_id.required' => 'Select warehouse from warehouse list option',
            'container_number.required' => 'Container number is required',
            'no_of_packets.required' => 'Number of packets is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $save_array = [
            'company_id'=> $request->get('company_id'),
            'warehouse_id'=> $request->get('warehouse_id'),
            'container_number'=> $request->get('container_number'),
            'no_of_packets'=> $request->get('no_of_packets'),
            'date'=> $request->get('date'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ];
        $stock_list = new StockList($save_array);
        $stock_list->save();

        $save_array = [
            'warehouse_id'=> $request->get('warehouse_id'),
            'stock_list_id'=> $stock_list->id,
            'description'=> $request->get('description'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
        ];
        $packet_list = new PacketList($save_array);
        $packet_list->save();

        foreach ($request->size as $key => $value) {
            $packetlist_detail_array[] = [
                'packet_list_id' => $packet_list->id,
                'size' => $value,
            ];
        }

        PacketListDetail::insert($packetlist_detail_array);


        return redirect()->route('stocklists')
            ->with('success', 'StockList created successfully.');
    }

    public function edit($id)
    {
        $stocklist = StockList::where('id', $id)->first();
        $companies = Company::where('is_deleted', 0)->get();
        $warehouses = Warehouse::where('is_deleted', 0)->get();

        $packetlist = PacketList::where('stock_list_id', $id)->where('is_deleted', 0)->first();

        $packetlist_details = DB::table('packet_list_details')
            ->where('packet_list_id', $packetlist->id)
            ->where('is_deleted', 0)
            ->get();

        return view('stocklists.edit', compact('stocklist', 'companies','warehouses','packetlist','packetlist_details'));
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
            'warehouse_id' => 'required',
            'container_number' => 'required',
            'no_of_packets' => 'required',
            'date' => 'required'
        ], [
            'company_id.required' => 'Select company from company list option',
            'warehouse_id.required' => 'Select warehouse from warehouse list option',
            'container_number.required' => 'Container number is required',
            'no_of_packets.required' => 'Number of packets is required',
            'date.required' => 'Date is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        StockList::where('id', $request->id)
            ->update([
                'company_id' => $request->company_id,
                'warehouse_id' => $request->warehouse_id,
                'container_number' => $request->container_number,
                'no_of_packets' => $request->no_of_packets,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);


        PacketList::where('stock_list_id', $request->id)
            ->update([
                'warehouse_id' => $request->warehouse_id,
                'stock_list_id' => $request->id,
                'description' => $request->description,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);

        $packet_list_id = PacketList::where('stock_list_id', $request->id)->first();

        for($i = 0; $i < count($request->size); $i++) {
            $packetlist_detail_array[] = [
                'id' => $request->packetlist_detail_id[$i],
                'packet_list_id' => $packet_list_id->id,
                'size' => $request->size[$i],
            ];
        }

        foreach($packetlist_detail_array as $detail_array) {
            if($detail_array['id'] == null) {
                PacketListDetail::insert($detail_array);
            } else {
                PacketListDetail::where('id', $detail_array['id'])
                    ->update([
                        'size' => $detail_array['size'],
                    ]);
            }
        }

        return redirect()->route('stocklists')
            ->with('success', 'Stock List updated successfully');
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

        StockList::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);

        PacketList::where('stock_list_id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);

        $packet_list_id = PacketList::where('stock_list_id', $request->id)->first();

        PacketListDetail::where('packet_list_id', $packet_list_id->id)
            ->update([
                'is_deleted' => 1,
            ]);

            echo json_encode(['message' => 'Deleted successfully']);
    }
}
