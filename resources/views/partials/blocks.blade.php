<div class="table-responsive">
    <table class="table m-0">
        <thead>
            <tr class="d-flex">
                <th class="col-6 col-sm-3">Reported User</th>
                <th class="col-5 col-sm-3">Date of Last Report</th>
                <th class="col-6 col-lg-3"></th>
            </tr>
        </thead>
        <tbody class="report_inbox">
            @foreach($users as $user)
            <tr class="d-flex">
                <td class="col-6 col-sm-3">{{ $user->name }}</td>
                <td class="col-5 col-sm-3">{{ $user->date }}</td>
                <td class="col-6 col-lg-3 d-flex justify-content-end">
                    @if($user->blocked)
                    <button type="button" class="btn btn-success unblock_button" data-id="{{ $user->id }}">Unblock</button>
                    @else
                    <button type="button" class="btn btn-warning block_button" data-id="{{ $user->id }}">Block</button>
                    @endif
                    <button type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>