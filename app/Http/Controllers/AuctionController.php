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
use \stdClass;

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

        if ($auction == null)
            return redirect()->route('homepage');

        $seller = User::find($auction->id_seller);
        if ($seller == null) {
            $seller = new stdClass();
            $seller->name = "Deleted User";
            $seller->rating = "0";
        }

        $seller_photo_id = DB::table('profile_photos')->where('id_user', $auction->id_seller)->first();

        if ($seller_photo_id != null) {
            $seller_photo = Image::find($seller_photo_id->id)->url;
        } else
            $seller_photo = "assets/blank_profile.png";

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

        $last_bids = DB::table('bids')->where('id_auction', $id)->leftJoin('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->take(4)->get();
        $bidding_history = DB::table('bids')->where('id_auction', $id)->leftJoin('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->get();
        return view('pages.view_auction',  ['auction' => $auction, 'category' => $category, 'dev_stage' => $dev_stage, 'color' => $color, 'skills' => $skills, 'seller' => $seller, 'seller_photo' => $seller_photo, 'picture_name' => $image->url, 'role' => $role, 'last_bids' => $last_bids, 'bidding_history' => $bidding_history]);
    }

    public function showEditForm($id)
    {
        $auction = Auction::find($id);

        if (Auth::id() != $auction->id_seller)
            return redirect()->route('homepage');

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

    public function stop($id)
    {
        $auction = Auction::find($id);
        //$this->authorize('update', $auction);
        $auction->id_status = 2;
        $auction->save();
        return redirect()->route('view_auction', ['id' => $auction->id]);
    }

    public function choose_methods(Request $request, $id)
    {
        $auction = Auction::find($id);
        //$this->authorize('update', $auction);
        $auction->id_payment_method = $request->input('payM');
        $auction->id_shipping_method = $request->input('shipM');
        $auction->save();
        return $id;
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

    public function search(Request $request)
    {
        if (!$request->has('mammals') && !$request->has('insects') && !$request->has('reptiles') && !$request->has('birds') && !$request->has('fishes') && !$request->has('amphibians')) {
            $mammals = 1;
            $insects = 2;
            $reptiles = 3;
            $birds = 4;
            $fishes = 5;
            $amphibians = 6;
        } else {
            if ($request->has('mammals'))
                $mammals = 1;
            else
                $mammals = null;
            if ($request->has('insects'))
                $insects = 2;
            else
                $insects = null;
            if ($request->has('reptiles'))
                $reptiles = 3;
            else
                $reptiles = null;
            if ($request->has('birds'))
                $birds = 4;
            else
                $birds = null;
            if ($request->has('fishes'))
                $fishes = 5;
            else
                $fishes = null;
            if ($request->has('amphibians'))
                $amphibians = 6;
            else
                $amphibians = null;
        }


        if (!$request->has('blue') && !$request->has('brown') && !$request->has('black') && !$request->has('yellow') && !$request->has('green') && !$request->has('red') && !$request->has('white')) {
            $blue = 1;
            $brown = 2;
            $black = 3;
            $yellow = 4;
            $green = 5;
            $red = 6;
            $white = 7;
        } else {
            if ($request->has('blue'))
                $blue = 1;
            else
                $blue = null;
            if ($request->has('brown'))
                $brown = 2;
            else
                $brown = null;
            if ($request->has('black'))
                $black = 3;
            else
                $black = null;
            if ($request->has('yellow'))
                $yellow = 4;
            else
                $yellow = null;
            if ($request->has('green'))
                $green = 5;
            else
                $green = null;
            if ($request->has('red'))
                $red = 6;
            else
                $red = null;
            if ($request->has('white'))
                $white = 7;
            else
                $white = null;
        }


        if (!$request->has('baby') && !$request->has('child') && !$request->has('teen') && !$request->has('adult') && !$request->has('elderly')) {
            $baby = 1;
            $child = 2;
            $teen = 3;
            $adult = 4;
            $elderly = 5;
        } else {
            if ($request->has('baby'))
                $baby = 1;
            else
                $baby = null;
            if ($request->has('child'))
                $child = 2;
            else
                $child = null;
            if ($request->has('teen'))
                $teen = 3;
            else
                $teen = null;
            if ($request->has('adult'))
                $adult = 4;
            else
                $adult = null;
            if ($request->has('elderly'))
                $elderly = 5;
            else
                $elderly = null;
        }


        if (!$request->has('baby') && !$request->has('child') && !$request->has('teen') && !$request->has('adult') && !$request->has('elderly')) {
            $climbs = 1;
            $jumps = 2;
            $talks = 3;
            $skates = 4;
            $olfaction = 5;
            $navigation = 6;
            $echo = 7;
            $acrobatics = 8;
        } else {
            if ($request->has('climbs'))
                $climbs = 1;
            else
                $climbs = null;
            if ($request->has('jumps'))
                $jumps = 2;
            else
                $jumps = null;
            if ($request->has('talks'))
                $talks = 3;
            else
                $talks = null;
            if ($request->has('skates'))
                $skates = 4;
            else
                $skates = null;
            if ($request->has('olfaction'))
                $olfaction = 5;
            else
                $olfaction = null;
            if ($request->has('navigation'))
                $navigation = 6;
            else
                $navigation = null;
            if ($request->has('echo'))
                $echo = 7;
            else
                $echo = null;
            if ($request->has('acrobatics'))
                $acrobatics = 8;
            else
                $acrobatics = null;
        }


        if ($request->input('search') != null) {
            $auctions = DB::select(DB::raw("
                SELECT DISTINCT auctions.id, url, species_name, current_price, age, ending_date
                FROM (((auctions JOIN features ON auctions.id = features.id_auction) JOIN animal_photos ON auctions.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id), to_tsquery(:text) AS query, 
                to_tsvector(name || ' ' || species_name || ' ' || description ) AS textsearch
                WHERE (id_category IN (:mammals, :insects, :reptiles, :birds, :fishes, :amphibians ))  
                AND (id_main_color IN (:blue, :green, :brown, :red, :black, :white, :yellow))
                AND (id_dev_stage IN (:baby, :child, :teen, :adult, :elderly))
                AND (current_price < :max_price OR :max_price IS NULL)
                AND (current_price > :min_price OR :min_price IS NULL)
                AND (id_skill IN (:climbs, :jumps, :talks, :skates, :olfaction, :navigation, :echo, :acrobatics))
                AND query @@ textsearch
                AND id_status = 0
                ORDER BY ending_date;
                "), array(
                'text' => $request->input('search'),
                'mammals' => $mammals, 'insects' => $insects, 'reptiles' => $reptiles, 'birds' => $birds, 'fishes' => $fishes, 'amphibians' => $amphibians,
                'blue' => $blue, 'green' => $green, 'brown' => $brown, 'red' => $red, 'black' => $black, 'white' => $white, 'yellow' => $yellow,
                'baby' => $baby,  'child' => $child, 'teen' => $teen, 'adult' => $adult, 'elderly' => $elderly,
                'max_price' => $request->input('max_price'), 'min_price' => $request->input('min_price'),
                'climbs' => $climbs, 'jumps' => $jumps, 'talks' => $talks, 'skates' => $skates, 'olfaction' => $olfaction, 'navigation' => $navigation, 'echo' => $echo, 'acrobatics' => $acrobatics
            ));
        } else {
            $auctions = DB::select(DB::raw("
                SELECT DISTINCT auctions.id, url, species_name, current_price, age, ending_date
                FROM (((auctions JOIN features ON auctions.id = features.id_auction) JOIN animal_photos ON auctions.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id) 
                WHERE (id_category IN (:mammals, :insects, :reptiles, :birds, :fishes, :amphibians ))  
                AND (id_main_color IN (:blue, :green, :brown, :red, :black, :white, :yellow))
                AND (id_dev_stage IN (:baby, :child, :teen, :adult, :elderly))
                AND (current_price < :max_price OR :max_price IS NULL)
                AND (current_price > :min_price OR :min_price IS NULL)
                AND (id_skill IN (:climbs, :jumps, :talks, :skates, :olfaction, :navigation, :echo, :acrobatics))
                AND id_status = 0
                ORDER BY ending_date;
                "), array(
                'mammals' => $mammals, 'insects' => $insects, 'reptiles' => $reptiles, 'birds' => $birds, 'fishes' => $fishes, 'amphibians' => $amphibians,
                'blue' => $blue, 'green' => $green, 'brown' => $brown, 'red' => $red, 'black' => $black, 'white' => $white, 'yellow' => $yellow,
                'baby' => $baby,  'child' => $child, 'teen' => $teen, 'adult' => $adult, 'elderly' => $elderly,
                'max_price' => $request->input('max_price'), 'min_price' => $request->input('min_price'),
                'climbs' => $climbs, 'jumps' => $jumps, 'talks' => $talks, 'skates' => $skates, 'olfaction' => $olfaction, 'navigation' => $navigation, 'echo' => $echo, 'acrobatics' => $acrobatics
            ));
        }

        return view('pages.search', ['auctions' => $auctions]);
    }

    public function fullTextSearch(Request $request)
    {
        $search = $request->input('search');
        if ($search != "") {
            $auctions = DB::select(DB::raw("
                SELECT auctions.id, species_name, current_price, age, ending_date, ts_rank_cd(textsearch, query) AS rank
                FROM auctions , to_tsquery(:text) AS query, 
                    to_tsvector(name || ' ' || species_name || ' ' || description ) AS textsearch
                WHERE query @@ textsearch AND id_status = 0
                ORDER BY rank DESC;
                "), array('text' => $search));
        } else {
            $auctions = DB::table('auctions')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('auctions.id_status', '=', 0)->get();
        }

        return view('pages.search', ['auctions' => $auctions]);
    }

}
