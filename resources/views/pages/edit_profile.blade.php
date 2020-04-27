@extends('layouts.app')

@section('title', 'Create Auction')

@section('content')

<div class="bg-white pt-4">
    <div class="mainBody">
        <form method="POST" action="{{ route('edit_profile', ['id' => $profile->id]) }}" enctype="multipart/form-data">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <h2 class="mt-3 colorGreen mx-auto">Edit Profile</h2>

            <div class="d-flex flex-wrap align-items-center">

                <div class="mx-auto image-container">
                    <img class="edit_profile_img" src="{{url($photo)}}" alt="{{url($photo)}}">
                    <input id="image_upload" type="file" name="profile_photo" placeholder="Photo" capture>

                </div>
                <div class="mx-auto w-50 align-items-between image-container">
                    <div>
                        <label class="font-weight-bold mt-3">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="E.g.: John Doe" value="{{ $profile->name }}">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3">Endereço de email</label>
                        <input type="email" name="email" class="form-control" placeholder="E.g.: something@fe.up.pt" value="{{ $profile->email }}">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div>
                        <label class="font-weight-bold mt-3">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger my-4">{{ session('error') }}</div>
                    @endif
                    <div id="edit_profile_submit">
                        <button type="submit" class="btn btn-green p-2 mt-3">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="pt-3"></div>

    </div>
</div>
@endsection