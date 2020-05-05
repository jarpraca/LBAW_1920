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
use Exception;

class AuctionController extends Controller
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
    $auction = Auction::find($id);

    $seller = User::find($auction->id_seller);
    // $seller_photo = DB::table('profile_photos')->where('id_user', $auction->id_seller)->join('images', 'profile_photos.id', '=', 'images.id')->first();
    $photo_id = DB::table('animal_photos')->where('id_auction', $id)->first()->id;
    $image = Image::find($photo_id);

    $category = DB::table('categories')->where('id', $auction->id_category)->first()->type;
    $dev_stage = DB::table('development_stages')->where('id', $auction->id_dev_stage)->first()->type;
    $color = DB::table('main_colors')->where('id', $auction->id_main_color)->first()->type;
    $skills = DB::table('features')->where('id_auction', $id)->join('skills', 'features.id_skill', '=', 'skills.id')->get('type');

    $role = 'guest';
    if (Auth::check()) {
      $role = "user";
      $admin = DB::table('admins')->where('id', Auth::user()->id)->first();
      if ($admin != null)
        $role = 'admin';
      if (Auth::user()->id == $auction->id_seller)
        $role = 'seller';
    }

    $last_bids = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->take(4)->get();
    $bidding_history = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->get();
    return view('pages.view_auction',  ['auction' => $auction, 'category' => $category, 'dev_stage' => $dev_stage, 'color' => $color, 'skills' => $skills, 'seller' => $seller,/* 'seller_photo' => $seller_photo->url,*/ 'picture_name' => $image->url, 'role' => $role, 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
  }

  public function showEditForm($id)
  {
    $auction = Auction::find($id);
    $photo = DB::table('animal_photos')->where('id_auction', $auction->id)->first();

    if (!empty($photo)) {
      $image = Image::find($photo->id);
      return view('pages.edit_auction', ['auction' => $auction, 'photo' => $image]);
    } else
      return view('pages.edit_auction', ['auction' => $auction]);
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

    if (!Auth::check()) {
      return back()->withError("Please sign in before creating an auction.")->withInput();
    }
    if (gettype($request->input('starting_price')) == "integer")
      return back()->withError("The starting price must be a number.")->withInput();

    if (gettype($request->input('buyout_price')) == "integer")
      return back()->withError("The buyout price must be a number.")->withInput();

    if (
      $request->input('name') == null || $request->input('species_name') == null || $request->input('description') == null || $request->input('starting_price') == null || $request->input('buyout_price') == null
      || $request->input('category') == null ||  $request->input('age') == null || $request->input('color') == null || $request->input('dev_stage') == null || $request->input('ending_date') == null
    ) {
      return back()->withError("Please fill out all the fields.")->withInput();
    }

    try {
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
    } catch (Exception $exception) {
      // return back()->withError($exception->getMessage())->withInput();
      return back()->withError('An error occured while trying to create the auction, please verify if your inputs are valid and try again.')->withInput();
    }
  }

  public function delete($id)
  {
    $photo_id = DB::table('animal_photos')->where('id_auction', $id)->first()->id;
    $image = Image::find($photo_id);
    $auction = Auction::find($id);

    DB::table('animal_photos')->where('id', $photo_id)->delete();

    // $image->authorize('deleteAnimalPhoto', $auction);

    $image->delete(null, $photo_id);
    DB::table('images')->where('id', $photo_id)->delete();

    $auction->delete();

    return redirect()->route('homepage');
  }

  public function update(Request $request, $id)
  {
    if (!Auth::check()) {
      return back()->withError("Please sign in before editing an auction.")->withInput();
    }
    if (gettype($request->input('starting_price')) == "integer")
      return back()->withError("The starting price must be a number.")->withInput();

    if (gettype($request->input('buyout_price')) == "integer")
      return back()->withError("The buyout price must be a number.")->withInput();

    if (
      $request->input('name') == null || $request->input('species_name') == null || $request->input('description') == null
      || $request->input('category') == null ||  $request->input('age') == null || $request->input('color') == null || $request->input('dev_stage') == null || $request->input('ending_date') == null
    ) {
      return back()->withError("Please fill out all the fields.")->withInput();
    }

    $animal_photo = DB::table('animal_photos')->where('id_auction', $id)->first();

    if (!$request->hasFile('animal_picture')) {

      if ($animal_photo == null)
        return back()->withError("Please add an image.")->withInput();
    } else {
      DB::table('animal_photos')->where('id_auction', $id)->delete();
      $image = $request->file('animal_picture');
      $name = Str::slug($request->input('name')) . '_' . time();
      $folder = '/uploads/images/';
      $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
      $this->uploadOne($image, $folder, 'public', $name);

      $image = new Image();
      $image->url = $filePath;
      $image->save();

      $animal_photo = new AnimalPhoto();
      $animal_photo->id_auction = $id;
      $animal_photo->id = $image->id;
      $animal_photo->save();
    }

    try {
      $auction = Auction::find($id);

      $this->authorize('update', $auction);

      $auction->name = $request->input('name');
      $auction->species_name = $request->input('species_name');
      $auction->description = $request->input('description');
      $auction->id_category = $request->input('category');
      $auction->age = $request->input('age');
      $auction->starting_price = $request->input('starting_price');
      $auction->buyout_price = $request->input('buyout_price');
      $auction->id_main_color = $request->input('color');
      $auction->id_dev_stage = $request->input('dev_stage');
      $auction->ending_date = $request->input('ending_date');
      $auction->save();

      DB::table('features')->where('id_auction', $auction->id)->delete();

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

      return redirect()->route('view_auction', ['id' => $auction->id]);
    } catch (Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
      // return back()->withError('An error occured while trying to create the auction, please verify if your inputs are valid and try again.')->withInput();
    }
  }

  public function search()
  {
    $auctions = DB::select('
    SELECT DISTINCT auctions.id, species_name, current_price, age, ending_date
    FROM ((auctions JOIN features ON auctions.id = features.id_auction) JOIN auction_status ON auctions.id_status = auction_status.id)
    WHERE   (id_category = $category OR $category IS NULL)
        AND (id_main_color = $main_color OR $main_color IS NULL)
        AND (id_dev_stage = $dev_stage OR $dev_stage IS NULL)
        AND (current_price < $max_price OR $max_price IS NULL)
        AND (id_skill IN ($climbs, $jumps, $talks, $skates, $olfaction, $navigation, $echo, $acrobatics))
        AND auction_status.TYPE = "Ongoing"
    ORDER BY ending_date;
    ');
    return view('pages.search', ['auctions' => $auctions]);
  }

  public function full_text_search(Request $request)
  {
    $search = $request->input('search');
    $auctions = DB::select('
    SELECT auctions.id, species_name, current_price, age, ending_date, ts_rank_cd(textsearch, query) AS rank
    FROM (auctions JOIN auction_status ON auctions.id_status = auction_status.id), to_tsquery(' . $search . ') AS query, 
        to_tsvector(name || " " || species_name || " " || description ) AS textsearch
    WHERE query @@ textsearch AND auction_status.TYPE = "Ongoing"
    ORDER BY rank DESC;
    ');
    return view('pages.search', ['auctions' => $auctions]);
  }
}
