<?php

namespace App\Http\Controllers;

use App\Models\CompanyAccount;
use App\Models\CustomerBill;
use App\Models\CustomerBillDetail;
use App\Models\ImportStatus;
use App\Models\Length;
use App\Models\PacketListDetail;
use App\Models\ShippingArrival;
use App\Models\Status;
use App\Models\Company;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //
    public function get_performa_by_company(Request $request)
    {
        $performas = ImportStatus::where('company_id',$request->company_id)->where('is_deleted', 0)->get();
        echo json_encode([
            'performalist' => $performas,
        ]);
    }

    public function get_number_of_container_by_bl_number(Request $request)
    {
        $no_of_container = ShippingArrival::where('bl_tracking',$request->bl_number)->where('is_deleted', 0)->select('no_of_container')->first();
        echo json_encode([
            'no_of_container' => $no_of_container,
        ]);
    }

    public function get_all_status(Request $request)
    {
        $status = Status::all();
        echo json_encode([
            'status' => $status,
        ]);
    }

    public function get_bill_number_by_invoice(Request $request)
    {

        $invoicePrefix = $request->input('invoice');
        $latestInvoice = CustomerBill::where('invoice_number', 'LIKE', $invoicePrefix . '-%')
            ->orderBy('invoice_number', 'desc')
            ->first();
//
//        $latestInvoice = CustomerBill::whereRaw('TRIM(invoice_number) LIKE ?', [$invoicePrefix . '-%'])
//            ->orderBy('invoice_number', 'desc')
//            ->first();

//        dd($latestInvoice);

        $latestInvoiceNumber = null;

        if ($latestInvoice) {
            // Extract the latest invoice number
            $latestInvoiceNumber = $latestInvoice->invoice_number;
        }

        return response()->json(['success' => true, 'latestInvoiceNumber' => $latestInvoiceNumber]);
    }

    public function change_status(Request $request)
    {
//        dd($request->all());
        $id = $request->get('id');
        $status_id = $request->get('status_id');
        $table = $request->get('table');
        $modelInstance = app()->make('App\Models\\' . ucfirst($table));
        $record = $modelInstance::find($id);
        $record->status_id = $status_id;
        if($table == "CustomerBill") {
            $customerBill = CustomerBill::find($id);
            $customerBillStatus = $customerBill->status_id;
            if($customerBillStatus != $status_id) {
                $customerBillDetails = CustomerBillDetail::where('customer_bill_id',$id)->where('is_deleted',0)->get();
                if($customerBillStatus == 1) {
                    foreach($customerBillDetails as $customerBillDetail) {
                        Length::where('id', $customerBillDetail->length_id)->increment('quantity', $customerBillDetail->quantity);
                    }
                } else {
                    if($customerBillStatus == 2 && $status_id == 3) {

                    } elseif ($customerBillStatus == 3 && $status_id == 2) {

                    } else {
                        foreach($customerBillDetails as $customerBillDetail) {
                            Length::where('id', $customerBillDetail->length_id)->decrement('quantity', $customerBillDetail->quantity);
                        }
                    }
                }
                $record->save();
            }
        } else {
            $record->save();
        }

        echo json_encode([
            'message' => "Status changed successfully"
        ]);
    }

}
