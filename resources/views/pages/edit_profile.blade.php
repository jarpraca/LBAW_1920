@extends('layouts.app')

@section('title', 'Edit '. $profile->name . ' profile ')

@section('content')

<div class="bg-white pt-4">
    <div class="mainBody">
        <form method="POST" action="{{ route('edit_profile', ['id' => $profile->id]) }}" enctype="multipart/form-data">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <h2 class="mt-3 colorGreen mx-auto">Edit Profile</h2>

            <div class="d-flex flex-wrap align-items-center">

                <div class="mx-auto d-flex justify-content-center image-container">
                    <div class="image_edit_div">
                        @if($photo != "assets/blank_profile.png")
                        <a href="#" class="image_delete_button" data-toggle="modal" data-target="#modal_{{ $profile->id }}">
                            <img class="image_delete" src="{{url('assets/trash_button.png')}}" alt="Remove image">
                        </a>
                        @endif
                        <img class="w-100" src="{{url($photo)}}" alt="{{url($profile->name)}}">
                    </div>
                </div>
                <div class="mx-auto w-50 align-items-between image-container">
                    <div>
                        <label class="font-weight-bold mt-3" for="name">Name <span class="text-danger">* </span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="E.g.: John Doe" value="{{ $profile->name }}" required>
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3" for="email">Email Address <span class="text-danger">* </span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="E.g.: something@fe.up.pt" value="{{ $profile->email }}" required>
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3" for="password">Password </label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3" for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                    </div>
                    <div class="custom-file mt-4">
                        <input id="profile_picture" type="file" class="form-control" name="profile_picture" accept="image/*">
                        <label class="custom-file-label" for="profile_picture" id="profile_picture_label">Change Photo</label>
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger my-4">
                        <i class='fas fa-exclamation-triangle' style='font-size:24px'></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif
                </div>
                <div class="no-print" id="edit_profile_submit">
                    <button type="submit" class="btn btn-green p-2 mt-3">Save Changes</button>
                </div>
            </div>
    </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="modal_{{ $profile->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm profile photo deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete your profile photo?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary delete_photo_cancel" data-id="{{ $profile->id }}" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete_photo_confirm" data-id="{{ $profile->id }}">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-3"></div>

</div>
</div>
@endsection