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

    if($photo_id != null){
      $image = Image::find($photo_id->id);
      $url = $image->url;
    }
    else
      $url = "uploads/images/profilePicture.jpg";

    //Purchase History
    $purchase_history = DB::table('auctions')->join('animal_photos', 'auctions.id','=', 'animal_photos.id_auction')->join('images','animal_photos.id', '=','images.id')->where('id_winner', $id)->where('id_status', '=', 1)->select('auctions.id as id','species_name','current_price', 'age', 'ending_date','url')->orderBy('ending_date')->get();
    $my_auctions = DB::table('auctions')->join('animal_photos', 'auctions.id','=', 'animal_photos.id_auction')->join('images','animal_photos.id', '=','images.id')->where('id_seller', $id)->where('id_status', '=', 0)->select('auctions.id as id','species_name','current_price', 'age', 'ending_date','url')->orderBy('ending_date')->get();
    $ongoing_auctions = DB::table('auctions')->join('bids', 'bids.id_auction','=', 'auctions.id')->join('animal_photos', 'auctions.id','=', 'animal_photos.id_auction')->join('images','animal_photos.id', '=','images.id')->where('bids.id_buyer', $id)->where('id_status', '=', 0)->select('auctions.id as id','species_name','current_price', 'age', 'ending_date','url')->orderBy('ending_date')->get();
    $watchlist = DB::table('watchlists')->join('auctions', 'auctions.id','=','watchlists.id_auction')->join('animal_photos', 'auctions.id','=', 'animal_photos.id_auction')->join('images','animal_photos.id', '=','images.id')->where('id_buyer', $id)->where('id_status', '=', 1)->select('auctions.id as id','species_name','current_price', 'age', 'ending_date','url')->orderBy('ending_date')->get();

  //  $skills = DB::table('features')->where('id_auction', Auth::user()->id)->join('skills', 'features.id_skill', '=', 'skills.id')->get('type');

      //   $last_bids = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->take(4)->get();
   // $bidding_history = DB::table('bids')->where('id_auction', $id)->join('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->get();
    return view('pages.view_profile',  ['profile' => $user, 'picture_name' => $url, 'purchase_history' => $purchase_history, 'my_auctions' => $my_auctions, 'ongoing_auctions' => $ongoing_auctions, 'watchlist' => $watchlist]); // 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
  }

  public function delete($id) {
    $my_auctions = DB::table('auctions')->join('animal_photos', 'auctions.id','=', 'animal_photos.id_auction')->join('images','animal_photos.id', '=','images.id')->where('id_seller', $id)->where('id_status', '=', 0)->select('auctions.id as id','species_name','current_price', 'age', 'ending_date','url')->orderBy('ending_date')->get();
   
    foreach($my_auctions as $auction) {
      $auction_delete = Auction::find($auction->id);
      $auction_delete->delete();
    }

    $user = User::find($id);
    $user->delete();

    return redirect()->route('homepage');

  }





  // public function showEditForm($id)
  // {
  //   $auction = Auction::find($id);
  //   $photo = DB::table('animal_photos')->where('id_auction', $auction->id)->first();

  //   if(!empty($photo)){
  //     $image = Image::find($photo->id);
  //     return view('pages.edit_auction', ['auction' => $auction, 'photo' => $image]);
  //   }
  //   else
  //     return view('pages.edit_auction', ['auction' => $auction]);
  // }

  // public function showCreateForm()
  // {
  //   return view('pages.create_auction');
  // }

  // public function update(Request $request, $id)
  // {
  //   if (!Auth::check()) {
  //     return back()->withError("Please sign in before editing an auction.")->withInput();
  //   }
  //   if (gettype($request->input('starting_price')) == "integer")
  //     return back()->withError("The starting price must be a number.")->withInput();

  //   if (gettype($request->input('buyout_price')) == "integer")
  //     return back()->withError("The buyout price must be a number.")->withInput();

  //   if (
  //     $request->input('name') == null || $request->input('species_name') == null || $request->input('description') == null
  //     || $request->input('category') == null ||  $request->input('age') == null || $request->input('color') == null || $request->input('dev_stage') == null || $request->input('ending_date') == null
  //   ) {
  //     return back()->withError("Please fill out all the fields.")->withInput();
  //   }

  //   $animal_photo = DB::table('animal_photos')->where('id_auction', $id)->first();

  //   if (!$request->hasFile('animal_picture')) {

  //     if ($animal_photo == null)
  //       return back()->withError("Please add an image.")->withInput();
  //   } else {
  //     DB::table('animal_photos')->where('id_auction', $id)->delete();
  //     $image = $request->file('animal_picture');
  //     $name = Str::slug($request->input('name')) . '_' . time();
  //     $folder = '/uploads/images/';
  //     $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
  //     $this->uploadOne($image, $folder, 'public', $name);

  //     $image = new Image();
  //     $image->url = $filePath;
  //     $image->save();

  //     $animal_photo = new AnimalPhoto();
  //     $animal_photo->id_auction = $id;
  //     $animal_photo->id = $image->id;
  //     $animal_photo->save();
  //   }

  //   try {
  //     $auction = Auction::find($id);

  //     $this->authorize('update', $auction);

  //     $auction->name = $request->input('name');
  //     $auction->species_name = $request->input('species_name');
  //     $auction->description = $request->input('description');
  //     $auction->id_category = $request->input('category');
  //     $auction->age = $request->input('age');
  //     $auction->starting_price = $request->input('starting_price');
  //     $auction->buyout_price = $request->input('buyout_price');
  //     $auction->id_main_color = $request->input('color');
  //     $auction->id_dev_stage = $request->input('dev_stage');
  //     $auction->ending_date = $request->input('ending_date');
  //     $auction->save();

  //     DB::table('features')->where('id_auction', $auction->id)->delete();

  //     if ($request->has('climbs')) {
  //       $climbs = new Feature();
  //       $climbs->id_skill = 1;
  //       $climbs->id_auction = $auction->id;
  //       $climbs->save();
  //     }
  //     if ($request->has('jumps')) {
  //       $jumps = new Feature();
  //       $jumps->id_skill = 2;
  //       $jumps->id_auction = $auction->id;
  //       $jumps->save();
  //     }
  //     if ($request->has('talks')) {
  //       $talks = new Feature();
  //       $talks->id_skill = 3;
  //       $talks->id_auction = $auction->id;
  //       $talks->save();
  //     }
  //     if ($request->has('skates')) {
  //       $skates = new Feature();
  //       $skates->id_skill = 4;
  //       $skates->id_auction = $auction->id;
  //       $skates->save();
  //     }
  //     if ($request->has('olfaction')) {
  //       $olfaction = new Feature();
  //       $olfaction->id_skill = 5;
  //       $olfaction->id_auction = $auction->id;
  //       $olfaction->save();
  //     }
  //     if ($request->has('moon_nav')) {
  //       $moon_nav = new Feature();
  //       $moon_nav->id_skill = 6;
  //       $moon_nav->id_auction = $auction->id;
  //       $moon_nav->save();
  //     }
  //     if ($request->has('echolocation')) {
  //       $echolocation = new Feature();
  //       $echolocation->id_skill = 7;
  //       $echolocation->id_auction = $auction->id;
  //       $echolocation->save();
  //     }
  //     if ($request->has('acrobatics')) {
  //       $acrobatics = new Feature();
  //       $acrobatics->id_skill = 8;
  //       $acrobatics->id_auction = $auction->id;
  //       $acrobatics->save();
  //     }

  //     return redirect()->route('view_auction', ['id' => $auction->id]);
  //   } catch (Exception $exception) {
  //     return back()->withError($exception->getMessage())->withInput();
  //     // return back()->withError('An error occured while trying to create the auction, please verify if your inputs are valid and try again.')->withInput();
  //   }
  // }
}
