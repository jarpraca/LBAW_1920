<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Report;
use Illuminate\Http\Request;


class ReportController extends Controller
{

    public function addReport(Request $request, $id){
        
        $report = new Report();

       // $this->authorize('create', $report);

        $report->date = now()->toDateString();
        $report->id_buyer = Auth::user()->id;
        $report->id_seller = $id;
        $report->id_status = 0;
        $report->save();

        return back();
    }

}