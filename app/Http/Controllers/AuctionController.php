<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Traits\UploadTrait;

use App\Watchlist;
use App\Auction;
use App\User;
use App\Admin;
use App\AnimalPhoto;
use App\Image;
use App\Feature;
use App\Report;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
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
        DB::beginTransaction();

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

        $countdown = new Carbon($auction->ending_date, 'Europe/London');

        $add_watchlist = false;

        $role = 'guest';
        if (Auth::check()) {
            $role = "user";
            $admin = DB::table('admins')->where('id', Auth::user()->id)->first();
            $check_watchlists = Watchlist::where('id_auction', $id)->where('id_buyer', Auth::id())->first();
            // $check_watchlists = DB::table('watchlists')->where('id_auction', $id)->where('id_buyer', Auth::user()->id)->get();
            if ($check_watchlists != null)
                $add_watchlist = false;
            else
                $add_watchlist = true;

            if ($admin != null)
                $role = 'admin';
            if (Auth::user()->id == $auction->id_seller)
                $role = 'seller';
        }

        if ($auction->id_status == 1)
            $winner = User::find($auction->id_winner);
        else
            $winner = null;

        $last_bids = DB::table('bids')->where('id_auction', $id)->leftJoin('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->take(4)->get();
        $bidding_history = DB::table('bids')->where('id_auction', $id)->leftJoin('users', 'users.id', '=', 'bids.id_buyer')->select('users.name as name', 'bids.value as value', 'bids.id as id')->orderBy('value', 'desc')->get();

        DB::commit();

        return view('pages.view_auction',  ['auction' => $auction, 'category' => $category, 'dev_stage' => $dev_stage, 'color' => $color, 'skills' => $skills, 'seller' => $seller, 'seller_photo' => $seller_photo, 'picture_name' => $image->url, 'role' => $role, 'winner' => $winner, 'last_bids' => $last_bids, 'bidding_history' => $bidding_history, 'add_watchlist' => $add_watchlist,  'countdown' => $countdown]);
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
        if (Auth::check()) {
            if (Admin::find(Auth::id()))
                return redirect()->route('homepage');

            return view('pages.create_auction');
        } else
            return redirect()->route('login');
    }


    public function addWatchlist($id_auction)
    {
        if (!Auth::check())
            return redirect()->route("login");

        try {
            $watchlist = new Watchlist();
            $watchlist->id_buyer = Auth::id();
            $watchlist->id_auction = $id_auction;
            $watchlist->save();

            return $id_auction;
        } catch (Exception $e) {
            Log::emergency($e->getMessage());
            return $e->getMessage();
        }
    }

    public function removeWatchlist($id_auction)
    {
        try {
            Watchlist::where('id_auction', $id_auction)->where('id_buyer', Auth::id())->delete();

            return $id_auction;
        } catch (Exception $e) {
            Log::emergency($e->getMessage());
            return $e->getMessage();
        }
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

        $date = new Carbon($request->input('ending_date'), 'GMT+01');

        if (Carbon::now('GMT+01')->greaterThanOrEqualTo($date))
            return back()->withError("The ending date must be in the future")->withInput();

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
            Log::error($exception->getMessage());
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
            return back()->withError("Please sign in before editing an auction")->withInput();
        }

        $date = new Carbon($request->input('ending_date'), 'GMT+01');

        if (Carbon::now('GMT+01')->greaterThanOrEqualTo($date))
            return back()->withError("The ending date must be in the future")->withInput();

        if (
            $request->input('name') == null || $request->input('species_name') == null || $request->input('description') == null
            || $request->input('category') == null ||  $request->input('age') == null || $request->input('color') == null || $request->input('dev_stage') == null || $request->input('ending_date') == null
        ) {
            return back()->withError("Please fill out all the fields")->withInput();
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
            Log::error($exception->getMessage());
            return back()->withError($exception->getMessage())->withInput();
            // return back()->withError('An error occured while trying to create the auction, please verify if your inputs are valid and try again.')->withInput();
        }
    }

    public function search(Request $request)
    {
        DB::raw("
                UPDATE auctions SET ti =
                setweight(to_tsvector(coalesce(species_name,'')), 'A') ||
                setweight(to_tsvector(coalesce(name,'')), 'B') ||
                setweight(to_tsvector(coalesce(description,'')), 'C');
            ");
        if (!$request->exists('max_price')) {
            Log::emergency("FTS");
            return $this->fullTextSearch($request);
        }
        Log::emergency("SEARCH");

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


        if (
            !$request->has('blue') && !$request->has('brown') && !$request->has('black')
            && !$request->has('yellow') && !$request->has('green') && !$request->has('red')
            && !$request->has('white') && !$request->has('grey') && !$request->has('orange')
            && !$request->has('pink') && !$request->has('purple')
        ) {
            $blue = 1;
            $green = 2;
            $brown = 3;
            $red = 4;
            $black = 5;
            $white = 6;
            $yellow = 7;
            $orange = 8;
            $pink = 9;
            $purple = 10;
            $grey = 11;
        } else {
            if ($request->has('blue'))
                $blue = 1;
            else
                $blue = null;
            if ($request->has('green'))
                $brown = 2;
            else
                $brown = null;
            if ($request->has('brown'))
                $black = 3;
            else
                $black = null;
            if ($request->has('red'))
                $yellow = 4;
            else
                $yellow = null;
            if ($request->has('black'))
                $green = 5;
            else
                $green = null;
            if ($request->has('white'))
                $red = 6;
            else
                $red = null;
            if ($request->has('yellow'))
                $white = 7;
            else
                $white = null;
            if ($request->has('orange'))
                $orange = 8;
            else
                $orange = null;
            if ($request->has('pink'))
                $pink = 9;
            else
                $pink = null;
            if ($request->has('purple'))
                $purple = 10;
            else
                $purple = null;
            if ($request->has('grey'))
                $grey = 11;
            else
                $grey = null;
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
                SELECT DISTINCT auctions.id as id, url, species_name, current_price, age, ending_date, id_status
                FROM (((auctions LEFT JOIN features ON auctions.id = features.id_auction) JOIN animal_photos ON auctions.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id), 
                to_tsquery(:text) AS query, 
                to_tsvector(name || ' ' || species_name || ' ' || description ) AS textsearch
                WHERE (id_category IN (:mammals, :insects, :reptiles, :birds, :fishes, :amphibians ))  
                AND (id_main_color IN (:blue, :green, :brown, :red, :black, :white, :yellow, :orange, :pink, :purple, :grey))
                AND (id_dev_stage IN (:baby, :child, :teen, :adult, :elderly))
                AND (current_price < :max_price OR :max_price IS NULL)
                AND (current_price > :min_price OR :min_price IS NULL)
                AND (id_skill IN (:climbs, :jumps, :talks, :skates, :olfaction, :navigation, :echo, :acrobatics) OR id_skill IS NULL)
                AND query @@ textsearch
                AND id_status = 0
                ORDER BY ending_date;
                "), array(
                'text' => $request->input('search') . ':*',
                'mammals' => $mammals, 'insects' => $insects, 'reptiles' => $reptiles, 'birds' => $birds, 'fishes' => $fishes, 'amphibians' => $amphibians,
                'blue' => $blue, 'green' => $green, 'brown' => $brown, 'red' => $red, 'black' => $black, 'white' => $white, 'yellow' => $yellow, 'orange' => $orange, 'pink' => $pink, 'purple' => $purple, 'grey' => $grey,
                'baby' => $baby,  'child' => $child, 'teen' => $teen, 'adult' => $adult, 'elderly' => $elderly,
                'max_price' => $request->input('max_price'), 'min_price' => $request->input('min_price'),
                'climbs' => $climbs, 'jumps' => $jumps, 'talks' => $talks, 'skates' => $skates, 'olfaction' => $olfaction, 'navigation' => $navigation, 'echo' => $echo, 'acrobatics' => $acrobatics
            ));
            $search = $request->input('search');
        } else {
            $auctions = DB::select(DB::raw("
                SELECT DISTINCT auctions.id as id, url, species_name, current_price, age, ending_date, id_status
                FROM (((auctions LEFT JOIN features ON auctions.id = features.id_auction) JOIN animal_photos ON auctions.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id) 
                WHERE (id_category IN (:mammals, :insects, :reptiles, :birds, :fishes, :amphibians ))  
                AND (id_main_color IN (:blue, :green, :brown, :red, :black, :white, :yellow, :orange, :pink, :purple, :grey))
                AND (id_dev_stage IN (:baby, :child, :teen, :adult, :elderly))
                AND (current_price < :max_price OR :max_price IS NULL)
                AND (current_price > :min_price OR :min_price IS NULL)
                AND (id_skill IN (:climbs, :jumps, :talks, :skates, :olfaction, :navigation, :echo, :acrobatics) OR id_skill IS NULL)
                AND id_status = 0
                ORDER BY ending_date;
                "), array(
                'mammals' => $mammals, 'insects' => $insects, 'reptiles' => $reptiles, 'birds' => $birds, 'fishes' => $fishes, 'amphibians' => $amphibians,
                'blue' => $blue, 'green' => $green, 'brown' => $brown, 'red' => $red, 'black' => $black, 'white' => $white, 'yellow' => $yellow, 'orange' => $orange, 'pink' => $pink, 'purple' => $purple, 'grey' => $grey,
                'baby' => $baby,  'child' => $child, 'teen' => $teen, 'adult' => $adult, 'elderly' => $elderly,
                'max_price' => $request->input('max_price'), 'min_price' => $request->input('min_price'),
                'climbs' => $climbs, 'jumps' => $jumps, 'talks' => $talks, 'skates' => $skates, 'olfaction' => $olfaction, 'navigation' => $navigation, 'echo' => $echo, 'acrobatics' => $acrobatics
            ));
            $search = "";
        }

        if (Auth::check()) {
            foreach ($auctions as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }
        } else
            foreach ($auctions as $auction) {
                $auction->watchlisted = false;
            }

        return view('pages.search', ['auctions' => $auctions, 'search' => $search]);
    }

    public function fullTextSearch(Request $request)
    {
        $search = $request->input('search');
        if ($search != "") {
            $auctions = DB::select(DB::raw("
                SELECT auctions.id as id, url, species_name, current_price, age, ending_date, id_status, ts_rank_cd(textsearch, query) AS rank
                FROM ((auctions JOIN animal_photos ON auctions.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id), to_tsquery(:text) AS query, 
                    to_tsvector(species_name || ' ' || name || ' ' || description ) AS textsearch
                WHERE query @@ textsearch AND id_status = 0
                ORDER BY rank DESC;
                "), array('text' => $search . ':*'));
        } else {
            $auctions = DB::table('auctions')
                ->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')
                ->join('images', 'animal_photos.id', '=', 'images.id')
                ->where('auctions.id_status', '=', 0)
                ->select(['auctions.id as id', 'url', 'species_name', 'current_price', 'age', 'ending_date', 'id_status'])
                ->get();
        }

        foreach ($auctions as $auction) {
            Log::emergency($auction->species_name . ' - ' . $auction->rank);
        }

        if (Auth::check()) {
            foreach ($auctions as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }
        } else
            foreach ($auctions as $auction) {
                $auction->watchlisted = false;
            }

        return view('pages.search', ['auctions' => $auctions, 'search' => $search]);
    }

    public function addReport(Request $request, $id_auction)
    {
        try {

            $auction = Auction::find($id_auction);
            $report = new Report();

            // $this->authorize('create', $report);

            $report->date = now()->toDateString();
            $report->id_buyer = Auth::user()->id;
            $report->id_seller = $auction->id_seller;
            $report->id_status = 0;
            $report->save();

            return back()->withSuccess("Report successfully sent");
        } catch (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function rate(Request $request, $id_auction)
    {
        $auction = Auction::find($id_auction);

        $possible_values = array(1, 2, 3, 4, 5);

        if (!in_array($request->input('rate'), $possible_values)) {
            return back()->withError("The rate must be an integer between 1 and 5")->withInput();
        }

        $auction->rating_seller = $request->input('rate');
        $auction->save();

        return back();
    }
}
