<div class="table-responsive">
    <table class="table m-0">
        <thead>
            <tr class="d-flex">
                <th class="col-7 col-sm-3">User</th>
                <th class="col-5 col-sm-3">Date of Last Report</th>
                <th class="col-7 col-md-4 col-xl-3"></th>
            </tr>
        </thead>
        <tbody class="user_list" data-id="{{ $users->currentPage() }}">
            @foreach($users as $user)
            <tr class="d-flex">
                <td class="col-7 col-sm-3 d-flex align-items-center">{{ $user->name }}</td>
                <td class="col-5 col-sm-3 d-flex align-items-center">@if($user->date != null) {{ $user->date }} @else No reports @endif </td>
                <td class="col-7 col-md-4 col-xl-3 d-flex justify-content-start">
                    @if($user->blocked)
                    <button type="button" class="btn btn-success unblock_button" data-id="{{ $user->id }}">Unblock</button>
                    @else
                    <button type="button" class="btn btn-warning block_button" data-id="{{ $user->id }}">Block</button>
                    @endif
                    <button type="button" class="btn btn-danger delete_user_button" data-toggle="modal" data-target="#modal_{{ $user->id }}">Delete</button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm account deletion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                            Are you sure you want to delete {{ $user->name }}'s account?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary delete_user_cancel" data-id="{{ $user->id }}" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger delete_user_confirm" data-id="{{ $user->id }}">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>