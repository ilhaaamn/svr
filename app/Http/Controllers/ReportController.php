<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BikeModel;
use App\Document;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DetailReport;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $branches = Branch::all();
        $models = BikeModel::all();
        return view('display', compact('branches','models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//
////        return $request;

        try {
            $current_time = Carbon::now()->toDateTimeString();

            $report = new Report;
            $report->id_user = auth()->user()->id;
            $report->id_branch = $request->input('id_branch');
            $report->record_date = $current_time;

            $report->save();

//      Upload File to document
            if ($file = $request->file('document')) {
                foreach ($file as $document) {
                    $last = Document::latest('id')->first();
                    if ($last == null) {
                        $id = '1';
                    } else {
                        $id = $last->id + 1;
                    }
                    $name = 'REPORT' . $id . '.' . $document->extension();
                    $document->move('images', $name);

                    $newDocument = new Document;
                    $newDocument->id_report = $report->id;
                    $newDocument->pic_path = $name;

                    $newDocument->save();
                }

            }

            foreach ($request->input('id') as $i) {

                $report_detail = new DetailReport;

                $qty = $request->input('display-qty_' . $i);
                $talker = $request->input('talker_' . $i);
                $flyer = $request->input('flyer_' . $i);
                $streamer = $request->input('streamer_' . $i);

                $report_detail->id_model = $i;
                $report_detail->dsp_qty = $qty;
                $report_detail->talker = $talker;
                $report_detail->flayer = $flyer;
                $report_detail->streamer = $streamer;
                $report_detail->id_report = $report->id;

                $report_detail->save();

//            $data=array("id_user"=> auth()->user()->id, "id_branch"=> 1, "id_model"=> $i,"dsp_qty"=>$qty,"talker"=>$talker,"flayer"=>$flyer,
//                "streamer"=>$streamer, 'record_date'=>$current_time, 'pic_path' => $name);
//            DB::table('reports')->insert($data);


            }

            return redirect('/display')->with('success', 'Report inserted successfully');
        }
        catch (Exception $e){
            return redirect('/display')->with('failed', 'Woops, something is wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
