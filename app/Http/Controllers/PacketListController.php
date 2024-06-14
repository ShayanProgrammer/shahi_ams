<?php

namespace App\Http\Controllers;

use App\Models\PacketList;
use App\Models\PacketListDetail;
use App\Models\StockList;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;

class PacketListController extends Controller
{
    public function index()
    {
        $packetlists = PacketList::latest()->paginate(10);
        return view('packetlists.index', compact('packetlists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function warehouse_packetlists()
    {
        $packetlists = PacketList::latest()->paginate(10);
        return view('packetlists.index', compact('packetlists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function packetlist_list(Request $request)
    {
        try {
            $query = DB::table('packet_lists')
                ->leftjoin('stock_lists', 'stock_lists.id', '=', 'packet_lists.stock_list_id')
                ->leftjoin('warehouses', 'warehouses.id', '=', 'stock_lists.warehouse_id')
                ->select('packet_lists.*', 'warehouses.name as warehouse_name', 'stock_lists.container_number');
            if (isset($request->stocklist_id) && !empty($request->stocklist_id)) {
                $query->where('packet_lists.stock_list_id', '=', $request->stocklist_id);
            }

            $packetlists = $query->where('packet_lists.is_deleted', 0)->get();

            echo json_encode([
                'packetlists' => $packetlists
            ]);
            exit;
        } catch (\Exception $ex) {
            return json_encode([]);
        }
    }

    public function packetlist_detail(Request $request){
        $packetListDetail = PacketListDetail::where('packet_list_id', $request->packetlist_id)->where('is_deleted',0)->get();
        echo json_encode(["packetlist_detail" => $packetListDetail]);
        exit();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        return view('packetlists.create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'warehouse_id' => 'required',
            'stock_list_id' => 'required',
            'description' => 'required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $save_array = [
            'warehouse_id'=> $request->get('warehouse_id'),
            'stock_list_id'=> $request->get('stock_list_id'),
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

        return redirect()->route('packetlists')
            ->with('success', 'PacketList created successfully.');
    }

    public function edit($id)
    {
        $packetlist = PacketList::where('id', $id)->where('is_deleted', 0)->first();

        $warehouses = Warehouse::where('is_deleted', 0)->get();

        $stocklists = StockList::where('warehouse_id',$packetlist->warehouse_id)->where('is_deleted', 0)->get();

//        dd($stocklists);

        $packetlist_details = DB::table('packet_list_details')
            ->where('packet_list_id', $id)
            ->where('is_deleted', 0)
            ->get();

        return view('packetlists.edit', compact('packetlist', 'stocklists','packetlist_details','warehouses'));
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
        $this->validate($request, [
            'warehouse_id' => 'required',
            'stock_list_id' => 'required',
            'description' => 'required',
        ], [
            'warehouse_id.required' => 'Warehouse is required',
            'stock_list_id.required' => 'Stock container is required',
            'description.required' => 'Description is required',
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        PacketList::where('id', $request->id)
            ->update([
                'warehouse_id' => $request->warehouse_id,
                'stock_list_id' => $request->stock_list_id,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);


        for($i = 0; $i < count($request->size); $i++) {
            $packetlist_detail_array[] = [
                'id' => $request->packetlist_detail_id[$i],
                'packet_list_id' => $request->id,
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

        return redirect()->route('packetlists')
            ->with('success', 'Packet List updated successfully');
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

        PacketList::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }

    public function remove_single_packetlist(Request $request)
    {
        PacketListDetail::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode([
            'success' => true
        ]);
    }
}
