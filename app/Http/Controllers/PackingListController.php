<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ImportStatus;
use App\Models\ImportStatusDetail;
use App\Models\PackingList;
use App\Models\PackingListDetail;
use DB;
use Illuminate\Http\Request;

class PackingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packinglists = PackingList::latest()->paginate(10);
        return view('packinglists.index',compact('packinglists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function company_packinglists()
    {
        $packinglists = PackingList::latest()->paginate(10);
        return view('packinglists.index',compact('packinglists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    public function packinglist_list(Request $request){
        try{
            $query = DB::table('packing_lists')
                ->leftjoin('companies','companies.id','=','packing_lists.company_id')
                ->leftjoin('import_statuses','import_statuses.id','=','packing_lists.import_status_id')
                ->select('packing_lists.*','companies.name as company_name','import_statuses.performa');

            if(isset($request->importstatus) && !empty($request->importstatus)){
                $query->where('packing_lists.import_status_id', '=', $request->importstatus);
            }

            $packinglists = $query->where('packing_lists.is_deleted',0)->get();



            echo json_encode([
                'packinglists' => $packinglists
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
        $companies = Company::where('is_deleted',0)->get();
        $importstatuses = ImportStatus::where('is_deleted',0)->get();
        return view('packinglists.create',compact('companies','importstatuses'));
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
            'import_status_id' => 'required',
//            'container_number' => 'required',
            'port_name' => 'required',
            'date' => 'required',
            'file' => 'required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        $packinglist = new PackingList([
            'company_id' => $request->get('company_id'),
            'import_status_id' => $request->get('import_status_id'),
//            'container_number' => $request->get('container_number'),
            'port_name' => $request->get('port_name'),
            'date' => $request->get('date'),
            'added_by' => Auth()->user()->name,
            'status_id' => $status,
            'action' => 'Add',
//            'file' => $fileName
        ], [
            'company_id.required' => 'Select company from company list option',
            'import_status_id.required' => 'Select performa from performa list option',
            'port_name.required' => 'Port name is required',
            'date.required' => 'Date is required',
        ]);

        $packinglist->save();

        foreach ($request->container_number as $key => $value) {

            $fileName = time()."_".$request->file[$key]->getClientOriginalName();
            $request->file[$key]->move(public_path('uploads/packing_list'),  $fileName);

            $packinglist_detail_array[] = [
                'packing_list_id' => $packinglist->id,
                'container_number' => $value,
                'file_path' => $fileName
            ];
        }

//        dd($packinglist_detail_array);

        PackingListDetail::insert($packinglist_detail_array);



        return redirect()->route('packinglists')
            ->with('success','PackingList created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PackingList $packinglist)
    {
        return view('packinglists.show',compact('packinglist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $packinglist = PackingList::where('id',$id)->first();

        $packinglist_details = DB::table('packing_list_details')
            ->where('packing_list_id', $id)
            ->where('is_deleted',0)
            ->get();

        $importstatuses = ImportStatus::where('company_id',$packinglist->company_id)->where('is_deleted',0)->get();

        $companies = Company::where('is_deleted',0)->get();
        return view('packinglists.edit',compact('packinglist','companies','packinglist_details','importstatuses'));
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
            'import_status_id' => 'required',
//            'container_number' => 'required',
            'port_name' => 'required',
            'date' => 'required',
            // 'file' => 'required'
        ], [
            'company_id.required' => 'Select company from company list option',
            'import_status_id.required' => 'Select performa from performa list option',
            'port_name.required' => 'Port name is required',
            'date.required' => 'Date is required'
        ]);

        $status = 2;

        if(auth()->user()->role_id == 1) {
            $status = 1;
        }

        PackingList::where('id', $request->id)
            ->update([
                'company_id' => $request->company_id,
                'import_status_id' => $request->import_status_id,
                'port_name' => $request->port_name,
                'date' => $request->date,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Update',
            ]);


//        dd($request->rate[1]);
        for($i = 0; $i < count($request->container_number); $i++) {
            if(isset($request->file[$i])) {
                $packinglist_detail_array[] = [
                    'id' => $request->packing_list_detail_id[$i],
                    'packing_list_id' => $request->id,
                    'container_number' => $request->container_number[$i],
                    'file_path' => $request->file[$i]
                ];
            } else {
                $packinglist_detail_array[] = [
                    'id' => $request->packing_list_detail_id[$i],
                    'packing_list_id' => $request->id,
                    'container_number' => $request->container_number[$i],
                    'file_path' => null
                ];
            }
        }

//        dd($packinglist_detail_array);

        foreach($packinglist_detail_array as $detail_array) {
            if($detail_array['id'] == null) {
                $save_packing_list = new PackingListDetail();
                $save_packing_list->packing_list_id = $detail_array['packing_list_id'];
                $save_packing_list->container_number = $detail_array['container_number'];
                $fileName = time()."_".$detail_array['file_path']->getClientOriginalName();
                $detail_array['file_path']->move(public_path('uploads/packing_list'),  $fileName);
                $save_packing_list->file_path = $fileName;
                $save_packing_list->save();
            } else {
//                dd($detail_array['file_path']);
                if($detail_array['file_path'] != null) {
                    $fileName = time()."_".$detail_array['file_path']->getClientOriginalName();
                    $detail_array['file_path']->move(public_path('uploads/packing_list'),  $fileName);

                    PackingListDetail::where('id', $detail_array['id'])
                        ->update([
                            'container_number' => $detail_array['container_number'],
                            'file_path' => $fileName
                        ]);
                }
            }
        }

        return redirect()->route('packinglists')
            ->with('success','Packing List updated successfully');
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

        PackingList::where('id', $request->id)
            ->update([
                'is_deleted' => 1,
                'added_by' => Auth()->user()->name,
                'status_id' => $status,
                'action' => 'Delete',
            ]);
            echo json_encode(['message' => 'Deleted successfully']);
    }


    public function packing_list_detail(Request $request){
        $packingListDetail = PackingListDetail::where('packing_list_id', $request->packing_list_id)->where('is_deleted',0)->get();
        echo json_encode(["packing_list_detail" => $packingListDetail]);
        exit();
    }

    public function remove_single_packinglist(Request $request)
    {
        PackingListDetail::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);
        echo json_encode([
            'success' => true
        ]);
    }
}
