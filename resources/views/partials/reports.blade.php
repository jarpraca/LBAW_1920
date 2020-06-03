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
                        <a class="btn btn-outline-green" href="#" data-toggle="modal" data-target="#modal_report_{{ $report->id }}">
                            View
                        </a>
                    </div>
                    @endif
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="modal_report_{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $report->seller_name }}'s Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $report->description }}</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary approve_report_cancel" data-id="{{ $report->id }}" data-dismiss="modal">Cancel</button>
                            <div>
                            <button type="button" class="btn btn-success accept_report" data-id="{{ $report->id }}">Accept</button>
                            <button type="button" class="btn btn-danger deny_report" data-id="{{ $report->id }}">Deny</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $reports->links() }}
</div>