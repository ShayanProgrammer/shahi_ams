<?php

namespace App\Http\Controllers;

use App\Models\Length;
use App\Models\PacketList;
use App\Models\PacketListDetail;
use App\Models\StockList;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;

class LengthController extends Controller
{
    public function index()
    {
        $lengths = Length::latest()->paginate(10);
        return view('lengths.index', compact('lengths'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function warehouse_lengths()
    {
        $lengths = Length::latest()->paginate(10);
        return view('lengths.index', compact('lengths'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function length_list(Request $request)
    {
        try {
            $query = DB::table('packet_list_details')
                ->leftjoin('packet_lists', 'packet_lists.id', '=', 'packet_list_details.packet_list_id')
                ->leftjoin('stock_lists', 'stock_lists.id', '=', 'packet_lists.stock_list_id')
                ->leftjoin('warehouses', 'warehouses.id', '=', 'stock_lists.warehouse_id')
                ->leftJoin('lengths', 'lengths.packet_list_detail_id', '=', 'packet_list_details.id')
                ->select(
                    'packet_list_details.id',
                    'packet_list_details.size',
                    'packet_lists.description',
                    'warehouses.name as warehouse_name',
                    'stock_lists.container_number',
                    DB::raw('COALESCE(lengths.length, NULL) as length_value')
                );

            if (isset($request->stocklist_id) && !empty($request->stocklist_id)) {
                $query->where('packet_lists.stock_list_id', '=', $request->stocklist_id);
            }

            $lengths = $query->where('packet_list_details.is_deleted', 0)->get();

//            dd($lengths);

            echo json_encode([
                'lengths' => $lengths
            ]);
            exit;
        } catch (\Exception $ex) {
            return json_encode([]);
        }
    }

    public function length_detail(Request $request){
        $length_detail = Length::where('packet_list_detail_id', $request->length_id)->where('is_deleted',0)->get();
        echo json_encode(["length_detail" => $length_detail]);
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
        return view('lengths.create', compact('warehouses'));
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
            $length_detail_array[] = [
                'packet_list_id' => $packet_list->id,
                'size' => $value,
                'length' => $request->length[$key],
                'quantity' => $request->quantity[$key]
            ];
        }

        PacketListDetail::insert($length_detail_array);

        return redirect()->route('lengths')
            ->with('success', 'PacketList created successfully.');
    }

    public function edit($id)
    {
        $length_details = Length::where('packet_list_detail_id', $id)->where('is_deleted', 0)->get();
        return view('lengths.edit', compact('length_details'));
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
        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }
//        dd($request->all());
        for($i = 0; $i < count($request->length_id); $i++) {
            $length_detail_array[] = [
                'id' => $request->length_id[$i],
                'packet_list_detail_id' => $request->packet_list_detail_id,
                'length' => $request->length[$i],
                'quantity' => $request->quantity[$i],
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ];
        }
//        dd($length_detail_array);


        foreach($length_detail_array as $detail_array) {
            if($detail_array['id'] == 0) {
                $detail_array['id'] = null;
            }
            if($detail_array['id'] == null) {
                Length::insert($detail_array);
            } else {
                Length::where('id', $detail_array['id'])
                    ->update([
                        'packet_list_detail_id' => $request->packet_list_detail_id,
                        'length' => $detail_array['length'],
                        'quantity' => $detail_array['quantity'],
                        'added_by' => Auth()->user()->name,
                        'status_id' => $status,
                        'action' => 'Update',
                    ]);
            }
        }

        return redirect()->route('lengths')
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

        Length::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
        echo json_encode(['message' => 'Deleted successfully']);
    }

    public function remove_single_length(Request $request)
    {
        Length::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode([
            'success' => true
        ]);
    }
}
