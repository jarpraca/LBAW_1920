<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Traits\UploadTrait;

use App\Auction;
use App\User;
use App\Image;
use App\ProfilePhoto;
use App\Seller;
use App\Watchlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

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
        if (Auth::id() != $id)
            return redirect()->route('homepage');

        $user = User::find($id);
        $photo_id = DB::table('profile_photos')->where('id_user', $id)->first();

        if ($photo_id != null) {
            $image = Image::find($photo_id->id);
            $url = $image->url;
        } else
            $url = "assets/blank_profile.png";

        if (Admin::find($id) != null) {
            $purchase_history = null;
            $my_auctions = null;
            $bidding = null;
            $didnt_win = null;
            $watchlist = null;
            $previous_auctions = null;
        } else {

            if (Seller::find($id) == null) {
                $my_auctions = [];
                $previous_auctions = [];
            } else {
                $my_auctions = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_seller', $id)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->where('id_status', '=', 0)->orderBy('ending_date')->get();
                $previous_auctions = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_seller', $id)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->where('id_status', '<>', 0)->orderBy('ending_date')->get();

                if (Auth::check()) {
                    foreach ($my_auctions as $auction) {
                        $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                        if ($watchlist != null)
                            $auction->watchlisted = true;
                        else
                            $auction->watchlisted = false;
                    }
                } else
                    foreach ($my_auctions as $auction) {
                        $auction->watchlisted = false;
                    }
            }

            $purchase_history = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_winner', $id)->where('id_status', '=', 1)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->orderBy('ending_date')->get();

            foreach ($purchase_history as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }

            $bidding = DB::table('auctions')->distinct()->join('bids', 'bids.id_auction', '=', 'auctions.id')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('bids.id_buyer', $id)->where('id_status', '=', 0)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->orderBy('ending_date')->get();

            foreach ($bidding as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }

            $one_month_ago = Carbon::now()->subMonth()->toDateString();
            $didnt_win = DB::table('auctions')->distinct()->join('bids', 'bids.id_auction', '=', 'auctions.id')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('bids.id_buyer', $id)->where('id_status', '!=', 0)->where('id_winner', '!=', $id)->where('ending_date', '>=', $one_month_ago)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->orderBy('ending_date')->get();

            foreach ($didnt_win as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }

            $watchlist = DB::table('watchlists')->join('auctions', 'auctions.id', '=', 'watchlists.id_auction')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_buyer', $id)->where('id_status', '=', 0)->select('auctions.id as id', 'species_name', 'current_price', 'age', 'ending_date', 'url', 'id_status')->orderBy('ending_date')->get();

            foreach ($watchlist as $auction) {
                $watchlisted = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlisted != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }
        }

        return view('pages.view_profile',  ['profile' => $user, 'picture_name' => $url, 'purchase_history' => $purchase_history, 'my_auctions' => $my_auctions, 'previous_auctions' => $previous_auctions, 'bidding' => $bidding, 'didnt_win' => $didnt_win, 'watchlist' => $watchlist]); // 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
    }

    public function delete($id)
    {
        $my_auctions = Auction::where('id_seller', '=', $id)->get();

        foreach ($my_auctions as $auction) {
            if ($auction->id_status == 0)
                $auction->delete();
        }

        $user = User::find($id);
        $user->delete();

        return redirect()->route('homepage');
    }

    public function deletePhoto($id)
    {
        $photo = DB::table('profile_photos')->where('id_user', $id)->first();
        Log::emergency("1");
        if ($photo != null) {
            Log::emergency("2");
            DB::table('profile_photos')->where('id_user', $id)->delete();
            Log::emergency("3");
            $old_image = Image::find($photo->id);
            Log::emergency("4");
            $old_image->delete();
            Log::emergency("5");
        }

        return $id;
    }

    public function showEditForm($id)
    {
        if (Auth::id() != $id)
            return redirect()->route('homepage');

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
                $old_photo = DB::table('profile_photos')->where('id_user', $id)->first();
                if ($old_photo != null)
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

                if ($old_photo != null) {
                    $old_image = Image::find($old_photo->id);
                    $old_image->delete(null, $old_photo);
                }
            }

            $profile->save();

            return redirect()->route('profiles', ['id' => $profile->id]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            // return back()->withError('An error occured while trying to edit your profile, please verify if your inputs are valid and try again.')->withInput();
            return back()->withError($exception->__toString())->withInput();
        }
    }
}
