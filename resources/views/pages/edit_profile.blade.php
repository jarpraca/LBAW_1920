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
                    @isset($photo)
                    <div class="image_edit_div">
                        <a href="#" class="image_edit_button " data-id="{{ $photo }}">
                            <img class="image_edit" src="{{url('assets/trash_button.png')}}" alt="Remove image">
                        </a>
                        <img class="w-100" src="{{url($photo)}}" alt="{{url($profile->name)}}">
                    </div>
                    @endisset
                    <label style="display:none" for="image_upload"></label>
                    <input id="image_upload" type="file" name="profile_photo" accept="image/*">
                </div>
                <div class="mx-auto w-50 align-items-between image-container">
                    <div>
                        <label class="font-weight-bold mt-3" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="E.g.: John Doe" value="{{ $profile->name }}">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3" for="email">Endereço de email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="E.g.: something@fe.up.pt" value="{{ $profile->email }}">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3" for="password">Password</label>
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
                    <div class="alert alert-danger my-4">{{ session('error') }}</div>
                    @endif<div class="mx-auto image-container">

                    </div>
                    <div class="no-print" id="edit_profile_submit">
                        <button type="submit" class="btn btn-green p-2 mt-3">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="pt-3"></div>

    </div>
</div>
@endsection