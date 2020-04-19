<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Traits\UploadTrait;

use App\Auction;
use App\User;
use App\AnimalPhoto;
use App\Image;
use App\Feature;

class AuctionController extends Controller
{
    use UploadTrait;
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $auction = Auction::find($id);

        $seller = User::find($auction->id_seller);
        // $seller_photo = DB::table('profile_photos')->where('id_user', $auction->id_seller)->join('images', 'profile_photos.id', '=', 'images.id')->first();
        $photo_id = DB::table('animal_photos')->where('id_auction', $id)->first()->id;
        $image = Image::find($photo_id);

        $category = DB::table('categories')->where('id', $auction->id_category)->first()->type;
        $dev_stage = DB::table('development_stages')->where('id', $auction->id_dev_stage)->first()->type;
        $color = DB::table('main_colors')->where('id', $auction->id_main_color)->first()->type;
        $skills = DB::table('features')->where('id_auction', $id)->join('skills', 'features.id_skill', '=', 'skills.id')->get('type');

        $admin = DB::table('admins')->where('id', Auth::user()->id);

        $role = 'guest';
        if ($admin != null)
            $role = 'admin';
        if (Auth::user()->id == $auction->id_seller)
            $role = 'seller';
        else if (Auth::check())
            $role = 'user';

        $last_bids = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->take(4)->get();
        $bidding_history = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->get();
        return view('pages.view_auction',  ['auction' => $auction,'category' => $category, 'dev_stage' => $dev_stage, 'color' => $color, 'skills' => $skills, 'seller' => $seller,/* 'seller_photo' => $seller_photo->url,*/ 'picture_name' => $image->url, 'role' => $role, 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
    }

    public function showCreateForm()
    {
        return view('pages.create_auction');
    }

    /**
     * Creates a new auction.
     *
     * @return int The auction id.
     */
    public function create(Request $request)
    {
        $auction = new Auction();

        $this->authorize('create', $auction);

        $auction->name = $request->input('name');
        $auction->species_name = $request->input('species_name');
        $auction->description = $request->input('description');
        $auction->id_category = $request->input('category');
        $auction->age = $request->input('age');
        $auction->starting_price = $request->input('starting_price');
        $auction->buyout_price = $request->input('buyout_price');
        $auction->current_price = $request->input('starting_price');
        $auction->id_main_color = $request->input('color');
        $auction->id_dev_stage = $request->input('dev_stage');
        $auction->ending_date = $request->input('ending_date');
        $auction->id_status = 0;
        $auction->id_seller = Auth::user()->id;
        $auction->save();

        if ($request->has('climbs')) {
            $climbs = new Feature();
            $climbs->id_skill = 1;
            $climbs->id_auction = $auction->id;
            $climbs->save();
        }
        if ($request->has('jumps')) {
            $jumps = new Feature();
            $jumps->id_skill = 2;
            $jumps->id_auction = $auction->id;
            $jumps->save();
        }
        if ($request->has('talks')) {
            $talks = new Feature();
            $talks->id_skill = 3;
            $talks->id_auction = $auction->id;
            $talks->save();
        }
        if ($request->has('skates')) {
            $skates = new Feature();
            $skates->id_skill = 4;
            $skates->id_auction = $auction->id;
            $skates->save();
        }
        if ($request->has('olfaction')) {
            $olfaction = new Feature();
            $olfaction->id_skill = 5;
            $olfaction->id_auction = $auction->id;
            $olfaction->save();
        }
        if ($request->has('moon_nav')) {
            $moon_nav = new Feature();
            $moon_nav->id_skill = 6;
            $moon_nav->id_auction = $auction->id;
            $moon_nav->save();
        }
        if ($request->has('echolocation')) {
            $echolocation = new Feature();
            $echolocation->id_skill = 7;
            $echolocation->id_auction = $auction->id;
            $echolocation->save();
        }
        if ($request->has('acrobatics')) {
            $acrobatics = new Feature();
            $acrobatics->id_skill = 8;
            $acrobatics->id_auction = $auction->id;
            $acrobatics->save();
        }

        $image = $request->file('animal_picture');
        $name = Str::slug($request->input('name')) . '_' . time();
        $folder = '/uploads/images/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);

        $image = new Image();
        $image->url = $filePath;
        $image->save();

        $animal_photo = new AnimalPhoto();
        $animal_photo->id_auction = $auction->id;
        $animal_photo->id = $image->id;
        $animal_photo->save();

        return redirect()->route('view_auction', ['id' => $auction->id]);
    }

    public function delete(Request $request, $id)
    {
        $auction = Auction::find($id);

        $this->authorize('delete', $auction);
        $auction->delete();

        return $auction;
    }
}
