<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Auction;
use App\User;
use App\AnimalPhoto;
use App\Image;

class AuctionController extends Controller
{
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
    $photo_id = DB::table('animal_photos')->where('id_auction', $auction->id)->first()->id;
    $image = Image::find($photo_id);

    $admin = DB::table('admins')->where('id', Auth::user()->id);
   
    $role = 'guest';
    if($admin != null)
      $role = 'admin';
    if(Auth::user()->id == $auction->id_seller)
      $role = 'seller';
    else if(Auth::check())
      $role = 'user';
    
    return view('pages.view_auction',  ['auction' => $auction, 'seller'=> $seller, 'picture_name' => $image->url, 'role' => $role]);
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
    $auction->id_main_color = $request->input('color');
    $auction->id_dev_stage = $request->input('dev_stage');
    $auction->ending_date = $request->input('ending_date');
    $auction->id_status = 0;
    // $auction->image = $request->input('customFile');
    $auction->id_seller = Auth::user()->id;
    $auction->save();


    $photo = $request->file('animal_picture');
    $extension = $photo->getClientOriginalExtension();

    Storage::disk('public')->put($photo->getFilename() . '.' . $extension,  File::get($photo));

    $image = new Image();
    $image->url = $photo->getFilename() . '.' . $extension;
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
