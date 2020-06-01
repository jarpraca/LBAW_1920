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
            <tr class="d-flex report" data-id="{{ $report->id }}">
                <td class="col-5 col-sm-3 d-flex align-items-center">{{ $report->seller_name }}</td>
                <td class="col-5 col-sm-3 d-flex align-items-center">@if($report->buyer_name != null) {{ $report->buyer_name }} @else Deleted User @endif</td>
                @if($report->status == 0)
                <td class="col-3 col-sm-2 d-flex align-items-center"><span class="badge badge-warning py-2">Pending</span></td>
                @elseif($report->status == 1)
                <td class="col-3 col-sm-2 d-flex align-items-center"><span class="badge badge-success py-2">Approved</span></td>
                @elseif($report->status == 2)
                <td class="col-3 col-sm-2 d-flex align-items-center"><span class="badge badge-danger py-2">Denied</span></td>
                @endif
                <td class="col-4 col-sm-2 d-flex align-items-center">{{ $report->date }}</td>
                <td class="col-4 col-sm-2 d-flex align-items-center">
                    @if($report->status == 0)
                    <div class="dropdown show">
                        <a class="btn btn-outline-green dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item accept_report" data-id="{{ $report->id }}" href="#">Accept</a>
                            <a class="dropdown-item deny_report" data-id="{{ $report->id }}" href="#">Deny</a>
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