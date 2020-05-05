@extends('layouts.app')

@section('title', 'Create Auction')

@section('content')

<div class="bg-white pt-4">
    <section class="mainBody align-items-center justify-content-center">
        <form class="editAuction mx-auto" method="POST" action="{{ route('edit_auction', ['id' => $auction->id]) }}" enctype="multipart/form-data">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <div class="col">
                <h1 class="mt-3 colorGreen mx-auto">Edit Your Auction</h1>
            </div>
            @if (session('error'))
            <div class="alert alert-danger my-4">{{ session('error') }}</div>
            @endif
            <div class="d-flex flex-wrap mt-3">
                <div class="col-12 col-sm-6">
                    <h3> Species Name </h3>
                    <input type="text" name="species_name" id="species_name" class="form-control outline-green mx-0" value="{{  $auction->species_name }}" />
                </div>
                <div class="col-12 col-sm-6">
                    <h3> Name </h3>
                    <input type="text" name="name" class="form-control outline-green mx-0" value="{{  $auction->name }}" />
                </div>
            </div>

            <div class="d-flex flex-row">
                <div class="col">
                    <h3 class="mt-3"> Description </h3>
                    <textarea name="description" id="description" class="form-control borderColorGreen w-100" rows="7">{{ $auction->description }}</textarea>
                </div>
            </div>
            <div class="form-group d-flex flex-row mt-3">
                <div class="col">
                    <label class="font-weight-bold font-size"> Select Category </label>
                    <select name="category" id="category" class="outline-green form-control" value="{{ $auction->id_category }}" required>
                        <option value="0" hidden></option>
                        <option value="1" <?php if ($auction->id_category == '1') {
                                                echo ("selected");
                                            } ?>>Mammal</option>
                        <option value="2" <?php if ($auction->id_category == '2') {
                                                echo ("selected");
                                            } ?>>Insect</option>
                        <option value="3" <?php if ($auction->id_category == '3') {
                                                echo ("selected");
                                            } ?>>Reptile</option>
                        <option value="4" <?php if ($auction->id_category == '4') {
                                                echo ("selected");
                                            } ?>>Bird</option>
                        <option value="5" <?php if ($auction->id_category == '5') {
                                                echo ("selected");
                                            } ?>>Fish</option>
                        <option value="6" <?php if ($auction->id_category == '6') {
                                                echo ("selected");
                                            } ?>>Amphibian</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size"> Age </label>
                    <input type="text" name="age" class="form-control outline-green" value="{{  $auction->age }}" />
                </div>
            </div>

            <div class="d-flex flex-row mt-4">
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size">
                        Starting Price
                    </label>
                    <input type="text" name="starting_price" class="form-control outline-green" value="{{  $auction->starting_price }}" />
                </div>
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size">
                        Buyout Price
                    </label>
                    <input type="text" name="buyout_price" class="form-control outline-green" value="{{  $auction->buyout_price }}" />
                </div>
            </div>

            <div class="d-flex flex-row mt-3">
                <div class="col">
                    <h3 class="mt-3"> Skills </h3>
                    <div class="d-flex flex-wrap">
                        <div class="col-6 col-sm-3">
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="climbs">
                                <label class="form-check-label" for="gridCheck1">
                                    Climbs
                                </label>
                            </div>
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck2" name="jumps">
                                <label class="form-check-label" for="gridCheck2">
                                    Jumps
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck3" name="talks">
                                <label class="form-check-label" for="gridCheck3">
                                    Talks
                                </label>
                            </div>
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck4" name="skates">
                                <label class="form-check-label" for="gridCheck4">
                                    Skates
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck5" name="olfaction">
                                <label class="form-check-label" for="gridCheck5">
                                    Olfaction
                                </label>
                            </div>
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck6" name="moon_nav">
                                <label class="form-check-label" for="gridCheck6">
                                    Moonlight Navigation
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck7" name="echolocation">
                                <label class="form-check-label" for="gridCheck7">
                                    Echolocation
                                </label>
                            </div>
                            <div class="form-check row">
                                <input class="form-check-input" type="checkbox" id="gridCheck8" name="acrobatics">
                                <label class="form-check-label" for="gridCheck8">
                                    Acrobatics
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-row mt-3">
                <div class="col">
                    <label class="font-weight-bold font-size"> Select Color </label>
                    <select id="color" name="color" class="outline-green form-control" required>
                        <option value="0" hidden></option>
                        <option value="1" <?php if ($auction->id_main_color == '1') {
                                                echo ("selected");
                                            } ?>>Blue</option>
                        <option value="2" <?php if ($auction->id_main_color == '2') {
                                                echo ("selected");
                                            } ?>>Green</option>
                        <option value="3" <?php if ($auction->id_main_color == '3') {
                                                echo ("selected");
                                            } ?>>Brown</option>
                        <option value="4" <?php if ($auction->id_main_color == '4') {
                                                echo ("selected");
                                            } ?>>Red</option>
                        <option value="5" <?php if ($auction->id_main_color == '5') {
                                                echo ("selected");
                                            } ?>>Black</option>
                        <option value="6" <?php if ($auction->id_main_color == '6') {
                                                echo ("selected");
                                            } ?>>White</option>
                        <option value="7" <?php if ($auction->id_main_color == '7') {
                                                echo ("selected");
                                            } ?>>Yellow</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size"> Select Dev. Stage </label>
                    <select name="dev_stage" id="dev_stage" class="outline-green form-control" value="{{  $auction->id_dev_stage }}" required>
                        <option value="0" hidden></option>
                        <option value="1" <?php if ($auction->id_dev_stage == '1') {
                                                echo ("selected");
                                            } ?>>Baby</option>
                        <option value="2" <?php if ($auction->id_dev_stage == '2') {
                                                echo ("selected");
                                            } ?>>Child</option>
                        <option value="3" <?php if ($auction->id_dev_stage == '3') {
                                                echo ("selected");
                                            } ?>>Teen</option>
                        <option value="4" <?php if ($auction->id_dev_stage == '4') {
                                                echo ("selected");
                                            } ?>>Adult</option>
                        <option value="5" <?php if ($auction->id_dev_stage == '5') {
                                                echo ("selected");
                                            } ?>>Elderly</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <label for="date-input" class="font-weight-bold font-size">Date</label>
                <input class="form-control outline-green" type="date" value="{{  $auction->ending_date }}" id="date-input" name="ending_date">
            </div>
            <div class="col-12 mt-3">
                <label class="font-weight-bold font-size"> Images </label>
                <div class="d-flex flex-row">
                    @isset($photo)
                    <a href="#" class="image_delete w-25 mr-5" data-id="{{ $photo->id }}">
                        <img src="{{url($photo->url)}}" alt="{{url($photo->url)}}" class="w-100">
                    </a>
                    @endisset
                    <div class="custom-file">
                        <input id="animal_picture" type="file" class="form-control" name="animal_picture">
                        <label class="custom-file-label" for="animal_picture" id="animal_picture_label">Add Photo</label>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center">
                <button class="btn btn-green text-white mx-auto text-center mt-5" type="submit">Save Changes</button>
            </div>
        </form>
        <div class="py-3"></div>
    </section>
</div>
@endsection