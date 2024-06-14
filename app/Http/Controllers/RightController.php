<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use DB;
use Illuminate\Http\Request;

class RightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $rights = Expense::latest()->paginate(10);
        return view('rights.index');
    }

    public function right_list(Request $request)
    {
//        dd($request->all());
        try{
            $tableName = $request->module_name;

            $query = DB::table($tableName)
                ->join('status', 'status.id', '=', $tableName . '.status_id')
                ->select($tableName . '.*', 'status.status');


            //Filters
            if(isset($request->from_date) && !empty($request->from_date)){
                $query->where('date', '>=', $request->from_date);
            }
            if(isset($request->to_date) && !empty($request->to_date)){
                $query->where('date', '<=', $request->to_date);
            }
            //End


            $responses = $query->get();

//            dd($responses);

            echo json_encode([
                'response' => $responses
            ]);
            exit;
        } catch (\Exception $ex) {
            return json_encode([]);
        }
    }

    public function general_view_detail(Request $request)
    {
        $id = $request->id;
        $table = $request->table;
        $viewDetail = DB::table($table)->where('id', $id)->first();

        if($table == 'companies') {
            $detail = DB::table($table)->where('id', $id)->get();
        } elseif($table == 'account_payments') {
            $detail = DB::table($table)->join('companies','companies.id','=','account_payments.company_id')
                ->where('account_payments.id', $id)->select('account_payments.*','companies.name as company_name')->get();
        } elseif($table == 'import_statuses') {
            $detail = DB::table($table)->join('companies','companies.id','=','import_statuses.company_id')
                ->join('import_status_details','import_status_details.import_status_id','=','import_statuses.id')
                ->where('import_statuses.id', $id)->select('import_status_details.*','companies.name as company_name')->get();
        } elseif($table == 'packing_lists') {
            $detail = DB::table($table)->join('companies','companies.id','=','packing_lists.company_id')
                ->join('packing_list_details','packing_list_details.packing_list_id','=','packing_lists.id')
                ->where('packing_lists.id', $id)->select('packing_list_details.*','companies.name as company_name')->get();
        } elseif($table == 'shipping_arrivals') {
            $detail = DB::table($table)->join('companies','companies.id','=','shipping_arrivals.company_id')
                ->join('shipping_arrival_details','shipping_arrival_details.shipping_arrival_id','=','shipping_arrivals.id')
                ->where('shipping_arrivals.id', $id)->select('shipping_arrival_details.*','companies.name as company_name')->get();
        } elseif($table == 'clearing_agents') {
            $detail = DB::table($table)->where('id', $id)->get();
        } elseif($table == 'clearing_agent_accounts') {
            $detail = DB::table($table)->join('clearing_agents', 'clearing_agents.id', '=', 'clearing_agent_accounts.clearing_agent_id')
                ->where('clearing_agent_accounts.id', $id)->select('clearing_agent_accounts.*', 'clearing_agents.name as clearing_agent_name')->get();
        } elseif($table == 'warehouses') {
            $detail = DB::table($table)->where('id', $id)->get();
        } elseif($table == 'stock_lists') {
            $detail = DB::table($table)->join('companies', 'companies.id', '=', 'stock_lists.company_id')
                ->join('warehouses', 'warehouses.id', '=', 'stock_lists.warehouse_id')
                ->where('stock_lists.id', $id)->select('stock_lists.*', 'warehouses.name as warehouse_name', 'companies.name as company_name')->get();
        } elseif($table == 'packet_lists') {
            $detail = DB::table($table)->join('warehouses', 'warehouses.id', '=', 'packet_lists.warehouse_id')
                ->join('stock_lists', 'stock_lists.id', '=', 'packet_lists.stock_list_id')
                ->join('packet_list_details', 'packet_list_details.packet_list_id', '=', 'packet_lists.id')
                ->where('packet_lists.id', $id)->select('packet_list_details.*', 'warehouses.name as warehouses_name', 'stock_lists.container_number as stock_container_number')->get();
        } elseif($table == 'customers') {
            $detail = DB::table($table)->where('id', $id)->get();
        } elseif($table == 'customer_payments') {
            $detail = DB::table($table)->leftjoin('customers', 'customers.id', '=', 'customer_payments.customer_id')
                ->leftjoin('payment_types', 'payment_types.id', '=', 'customer_payments.payment_type_id')
                ->leftjoin('banks', 'banks.id', '=', 'customer_payments.bank_id')
                ->where('customer_payments.id', $id)->select('customer_payments.*', 'customers.name as customer_name', 'payment_types.name as payment_type_name', 'banks.name as bank_name')->get();
        } elseif($table == 'customer_bills') {
            $detail = DB::table($table)->leftjoin('customer_bill_details', 'customer_bill_details.customer_bill_id', '=', 'customer_bills.id')
                ->leftjoin('customers', 'customers.id', '=', 'customer_bills.customer_id')
                ->leftjoin('payment_types', 'payment_types.id', '=', 'customer_bills.payment_type_id')
                ->leftjoin('banks', 'banks.id', '=', 'customer_bills.bank_id')
                ->leftjoin('warehouses', 'warehouses.id', '=', 'customer_bill_details.warehouse_id')
                ->leftjoin('stock_lists', 'stock_lists.id', '=', 'customer_bill_details.stocklist_id')
                ->leftjoin('packet_lists', 'packet_lists.id', '=', 'customer_bill_details.packetlist_id')
                ->leftjoin('packet_list_details', 'packet_list_details.id', '=', 'customer_bill_details.packetlist_detail_id')
                ->leftjoin('lengths', 'lengths.id', '=', 'customer_bill_details.length_id')
                ->where('customer_bills.id', $id)
                ->select(
                    'customer_bill_details.*',
                    'customers.name as customer_name',
                    'payment_types.name as payment_type_name',
                    'banks.name as bank_name',
                    'warehouses.name as warehouse_name',
                    'stock_lists.container_number as stock_container_number',
                    'packet_lists.description as packet_list_description',
                    'packet_list_details.size as size',
                    'lengths.length as length',
                    'customer_bills.total as total_bill',
                )->get();
        } elseif($table == 'banks') {
            $detail = DB::table($table)->where('id', $id)->get();
        } elseif($table == 'import_duties') {
            $detail = DB::table($table)->join('banks', 'banks.id', '=', 'import_duties.bank_id')
                ->where('import_duties.id', $id)->select('import_duties.*', 'banks.name as bank_name')->get();
        } elseif($table == 'expenses') {
            $detail = DB::table($table)->where('id', $id)->get();
        }

//        dd($viewDetail);
        echo json_encode(["detail" => $detail]);
        exit();
    }

}
