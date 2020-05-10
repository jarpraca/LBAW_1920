<div class="table-responsive">
    <table class="table m-0">
        <thead>
            <tr class="d-flex">
                <th class="col-5 col-sm-3">Reported User</th>
                <th class="col-5 col-sm-3">Reported By</th>
                <th class="col-3 col-sm-2">Status</th>
                <th class="col-4 col-sm-2">Date</th>
                <th class="col-4 col-sm-2"></th>
            </tr>
        </thead>
        <tbody class="report_inbox">
            @foreach($reports as $report)
            <tr class="d-flex report_{{ $report->id }}">
                <td class="col-5 col-sm-3">{{ $report->seller_name }}</td>
                <td class="col-5 col-sm-3">{{ $report->buyer_name }}</td>
                @if($report->status == 0)
                <td class="col-3 col-sm-2"><span class="badge badge-warning py-2">Pending</span></td>
                @elseif($report->status == 1)
                <td class="col-3 col-sm-2"><span class="badge badge-success py-2 ">Approved</span></td>
                @elseif($report->status == 2)
                <td class="col-3 col-sm-2"><span class="badge badge-danger py-2">Denied</span></td>
                @endif
                <td class="col-4 col-sm-2">{{ $report->date }}</td>
                <td class="col-4 col-sm-2">
                    @if($report->status == 0)
                    <div class="dropdown show">
                        <a class="btn btn-outline-green dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item accept_report" href="{{ $report->id }}">Accept</a>
                            <a class="dropdown-item deny_report" href="{{ $report->id }}">Deny</a>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $reports->links() }}
</div>