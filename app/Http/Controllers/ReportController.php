<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Company;
use App\Models\PacketListDetail;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stock_report()
    {
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        $companies = Company::where('is_deleted', 0)->get();
        $sizes = PacketListDetail::where('is_deleted', 0)
            ->select('size')
            ->distinct()
            ->get();
        return view('reports.stock_report',compact('warehouses', 'companies','sizes'));
    }

    public function stock_report_list(Request $request){
        try{
            $query = DB::table('packet_list_details')
            ->join('packet_lists','packet_lists.id','=','packet_list_details.packet_list_id')
            ->join('stock_lists','stock_lists.id','=','packet_lists.stock_list_id')
            ->join('warehouses','warehouses.id','=','stock_lists.warehouse_id')
            ->join('companies','companies.id','=','stock_lists.company_id')
            ->join('lengths','lengths.packet_list_detail_id','=','packet_list_details.id');

            if(isset($request->company_id) && !empty($request->company_id)){
                $query->where('companies.id', '=', $request->company_id);
            }
            if(isset($request->warehouse_id) && !empty($request->warehouse_id)){
                $query->where('warehouses.id', '=', $request->warehouse_id);
            }
            if(isset($request->stocklist_id) && !empty($request->stocklist_id)){
                $query->where('stock_lists.id', '=', $request->stocklist_id);
            }
            if(isset($request->packetlist_id) && !empty($request->packetlist_id)){
                $query->where('packet_lists.id', '=', $request->packetlist_id);
            }
            if(isset($request->size_id) && !empty($request->size_id)){
                $query->where('packet_list_details.size', '=', $request->size_id);
            }


            $stock_reports = $query->where('packet_list_details.is_deleted',0)->where('lengths.is_deleted',0)
                ->select(
                    'companies.name as company_name',
                            'warehouses.name as warehouse_name',
                            'stock_lists.container_number',
                            'packet_lists.description',
                            'packet_list_details.size',
                            'lengths.length',
                            'lengths.quantity'
                )
                ->get();

//            dd($banks);

            echo json_encode([
                'stock_reports' => $stock_reports
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }
}
