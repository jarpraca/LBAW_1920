<?php

namespace App\Http\Controllers;

use App\Block;
use App\Report;
use App\User;
use Illuminate\Support\Facades\DB;

use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use UploadTrait;

    public function show()
    {
        $reports = Report::join('users as s', 's.id', '=', 'reports.id_seller')
            ->join('users as b', 'b.id', '=', 'reports.id_buyer')
            ->orderBy('reports.date', 'desc')
            ->orderBy('s.name', 'asc')
            ->select(['reports.date AS date', 'reports.id_status AS status', 'b.name AS buyer_name', 's.name AS seller_name', 'reports.id AS id'])
            ->paginate(10);

        $admins = DB::table('admins')->select(['id']);
        $users = User::whereNotIn('users.id', $admins)
            ->join('reports', 'reports.id_seller', '=', 'users.id')
            ->select('users.id AS id', 'name', 'blocked', DB::raw('max(date) AS date'))
            ->groupBy('users.id')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('pages.admin', ['reports' => $reports, 'users' => $users]);
    }

    public function indexReports(Request $request)
    {
        $reports = Report::join('users as s', 's.id', '=', 'reports.id_seller')
            ->join('users as b', 'b.id', '=', 'reports.id_buyer')
            ->orderBy('reports.date', 'desc')
            ->orderBy('s.name', 'asc')
            ->select(['reports.date AS date', 'reports.id_status AS status', 'b.name AS buyer_name', 's.name AS seller_name', 'reports.id AS id'])
            ->paginate(10);

        return view('partials.reports', ['reports' => $reports])->render();
    }

    public function indexUsers(Request $request)
    {
        $admins = DB::table('admins')->select(['id']);
        $users = User::whereNotIn('users.id', $admins)
            ->join('reports', 'reports.id_seller', '=', 'users.id')
            ->select('users.id AS id', 'name', 'blocked', DB::raw('max(date) AS date'))
            ->groupBy('users.id')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('partials.blocks', ['users' => $users])->render();
    }

    public function updateReportStatus($id, $decision)
    {
        try {
            $report = Report::find($id);

            if ($report == null)
                return -1;

            // $this->authorize('update');

            if ($decision == "1")
                $decision = 1;
            else if ($decision == "2")
                $decision = 2;

            $report->id_status = $decision;
            $report->save();

            return $report->id;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function block($id)
    {
        try {
            $blocks = new Block();
            $blocks->id_seller = $id;
            $blocks->id_admin = Auth::user()->id;
            $blocks->end_date = Carbon::now()->addMonth()->toDateString();
            $blocks->save();

            return $id;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function unblock($id)
    {
        try {
            $user = User::find($id);

            if($user == null)
                return -1;

            $user->blocked = FALSE;
            $user->save();

            return $id;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}