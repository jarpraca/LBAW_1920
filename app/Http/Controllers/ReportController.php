<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;


class ReportController extends Controller
{

    public function addReport(Request $request, $id){
        
        $report = new Report();

        $this->authorize('create', $report);

        $report->date = now()->toDateTimeString('Y-m-d') ;
        $report->id_buyer = Auth::user()->id;
        $report->id_seller = $id;
        $report->id_status = 0;
        $report->save();

        return redirect()->route('view_auction', ['id' => $request->input('id_auction')]);
    }

}