<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Image;
use App\ProfilePhoto;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use UploadTrait;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/homepage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function redirectTo()
    {
        if(session(urlencode('link')) == null)
            return '/homepage';
        return session(urlencode('link'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name =  $data['name'];
        $user->email =  $data['email'];
        $user->password =  bcrypt($data['password']);
        $user->save();

        // if(Input::hasfile($data['profile_picture'])){
        //     $image = Input::file($data['profile_picture']);
        //     $name = Str::slug($data['name']) . '_' . time();
        //     $folder = '/uploads/profile_images/';
        //     $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        //     $this->uploadOne($image, $folder, 'public', $name);

        //     $image = new Image();
        //     $image->url = $filePath;
        //     $image->save();

        //     $profile_photo = new ProfilePhoto();
        //     $profile_photo->id_user = $user->id;
        //     $profile_photo->id = $image->id;
        //     $profile_photo->save();
        // }

        return $user;
    }
}
