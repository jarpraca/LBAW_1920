<?php

namespace App\Http\Controllers;

use App\Report;
use App\User;
use Illuminate\Support\Facades\DB;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use UploadTrait;

    public function show()
    {
        $reports = Report::join('users as s', 's.id', '=', 'reports.id_seller')
            ->join('users as b', 'b.id', '=', 'reports.id_buyer')
            ->orderBy('reports.date', 'desc')
            ->select(['reports.date AS date', 'reports.id_status AS status', 'b.name AS buyer_name', 's.name AS seller_name'])
            ->paginate(10);

        $admins = DB::table('admins')->select(['id']);
        $users = User::whereNotIn('users.id', $admins)->join('reports', 'reports.id_seller', '=', 'users.id')->orderBy('name', 'asc')->paginate(10);

        return view('pages.admin', ['reports' => $reports, 'users' => $users]);
    }

    public function indexReports(Request $request)
    {
        $reports = Report::join('users as s', 's.id', '=', 'reports.id_seller')
            ->join('users as b', 'b.id', '=', 'reports.id_buyer')
            ->orderBy('reports.date', 'desc')
            ->select(['reports.date AS date', 'reports.id_status AS status', 'b.name AS buyer_name', 's.name AS seller_name'])
            ->paginate(10);

        return view('partials.reports', ['reports' => $reports])->render();
    }

    public function indexUsers(Request $request)
    {
        $admins = DB::table('admins')->select(['id']);
        $users = User::whereNotIn('users.id', $admins)->join('reports', 'reports.id_seller', '=', 'users.id')->orderBy('name', 'asc')->paginate(10);

        return view('partials.blocks', ['users' => $users])->render();
    }
}
