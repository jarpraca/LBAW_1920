<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Traits\UploadTrait;

use App\Auction;
use App\User;
use App\Image;
use App\ProfilePhoto;
use Exception;

class UserController extends Controller
{
    use UploadTrait;
    /**
     * Shows the auction for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $photo_id = DB::table('profile_photos')->where('id_user', $id)->first();

        if ($photo_id != null) {
            $image = Image::find($photo_id->id);
            $url = $image->url;
        } else
            $url = "assets/blank_profile.png";

        $purchase_history = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_winner', $id)->where('id_status', '=', 1)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url')->orderBy('ending_date')->get();
        $my_auctions = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_seller', $id)->where('id_status', '=', 0)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url')->orderBy('ending_date')->get();
        $ongoing_auctions = DB::table('auctions')->join('bids', 'bids.id_auction', '=', 'auctions.id')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('bids.id_buyer', $id)->where('id_status', '=', 0)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url')->orderBy('ending_date')->get();
        $watchlist = DB::table('watchlists')->join('auctions', 'auctions.id', '=', 'watchlists.id_auction')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_buyer', $id)->where('id_status', '=', 1)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url')->orderBy('ending_date')->get();

        return view('pages.view_profile',  ['profile' => $user, 'picture_name' => $url, 'purchase_history' => $purchase_history, 'my_auctions' => $my_auctions, 'ongoing_auctions' => $ongoing_auctions, 'watchlist' => $watchlist]); // 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
    }

    public function delete($id)
    {
        $my_auctions = DB::table('auctions')->where('id_seller', $id)->get();

        foreach ($my_auctions as $auction) {
            $auction_delete = Auction::find($auction->id);
            $auction_delete->delete();
        }

        $user = User::find($id);
        $user->delete();

        return redirect()->route('homepage');
    }

    public function showEditForm($id)
    {
        $profile = User::find($id);
        $photo = DB::table('profile_photos')->where('id_user', $profile->id)->first();

        if (!empty($photo)) {
            $image = Image::find($photo->id);
            return view('pages.edit_profile', ['profile' => $profile, 'photo' => $image->url]);
        } else {
            $url = "assets/blank_profile.png";
            return view('pages.edit_profile', ['profile' => $profile, 'photo' => $url]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return back()->withError("Please sign in before editing your profile.")->withInput();
            }

            if ($request->input('name') == null || $request->input('email') == null) {
                return back()->withError("Fields name and email cannot be empty.")->withInput();
            }

            $profile = User::find($id);

            // $this->authorize('update', $auction);

            $profile->name = $request->input('name');
            $profile->email = $request->input('email');

            if ($request->input('password') != null) {
                if ($request->input('password') == $request->input('confirm_password')) {
                    $profile->password = bcrypt($request->input('password'));
                } else
                    return back()->withError("Password and Confirm Password don't match.")->withInput();
            }

            if ($request->hasFile('profile_picture')) {
                $old_photo = DB::table('profile_photos')->where('id_user', $id)->first()->id;
                DB::table('profile_photos')->where('id_user', $id)->delete();

                $image = $request->file('profile_picture');
                $name = Str::slug($request->input('email')) . '_' . time();
                $folder = '/uploads/images/profile/';
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                $this->uploadOne($image, $folder, 'public', $name);

                $image = new Image();
                $image->url = $filePath;
                $image->save();

                $profile_photo = new ProfilePhoto();
                $profile_photo->id_user = $id;
                $profile_photo->id = $image->id;
                $profile_photo->save();

                $old_image = Image::find($old_photo);
                $old_image->delete(null, $old_photo);
            }

            $profile->save();

            return redirect()->route('profiles', ['id' => $profile->id]);
        } catch (Exception $exception) {
            // return back()->withError('An error occured while trying to edit your profile, please verify if your inputs are valid and try again.')->withInput();
            return back()->withError($exception->__toString())->withInput();
        }
    }
}
