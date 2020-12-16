@extends('layouts.app')

@section('title','Edit Auction '. $auction->name . '')

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
            <div class="alert alert-danger my-4">
                <i class='fas fa-exclamation-triangle' style='font-size:24px'></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif
            <div class="d-flex flex-wrap mt-3">
                <div class="col-12 col-sm-6">
                    <label for="species_name"> Species Name <span class="text-danger">* </span></label>
                    <input type="text" name="species_name" id="species_name" class="form-control outline-green mx-0" value="{{  $auction->species_name }}" required />
                </div>
                <div class="col-12 col-sm-6">
                    <label for="name"> Name <span class="text-danger">* </span></label>
                    <input type="text" id="name" name="name" class="form-control outline-green mx-0" value="{{  $auction->name }}" required />
                </div>
            </div>

            <div class="d-flex flex-row">
                <div class="col">
                    <label for="description" class="mt-3"> Description <span class="text-danger">* </span></label>
                    <textarea name="description" id="description" class="form-control borderColorGreen w-100" rows="7" required>{{ $auction->description }}</textarea>
                </div>
            </div>
            <div class="form-group d-flex flex-row mt-3">
                <div class="col">
                    <label class="font-weight-bold font-size" for="category"> Select Category <span class="text-danger">* </span></label>
                    <select name="category" id="category" class="outline-green form-control" required>
                        <option value="" hidden>Select Category</option>
                        <option value="1" @if($auction->id_category == '1') selected @endif >Mammal</option>
                        <option value="2" @if($auction->id_category == '2') selected @endif >Insect</option>
                        <option value="3" @if($auction->id_category == '3') selected @endif >Reptile</option>
                        <option value="4" @if($auction->id_category == '4') selected @endif >Bird</option>
                        <option value="5" @if($auction->id_category == '5') selected @endif >Fish</option>
                        <option value="6" @if($auction->id_category == '6') selected @endif >Amphibian</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size" for="age"> Age <span class="text-danger">* </span></label>
                    <input type="text" name="age" id="age" class="form-control outline-green" value="{{  $auction->age }}" required />
                </div>
            </div>

            <div class="d-flex flex-row mt-4">
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size" for="starting_price">
                        Starting Price <span class="text-danger">* </span>
                    </label>
                    <input type="number" min="0" id="starting_price" name="starting_price" class="form-control outline-green" value="{{ $auction->starting_price }}" @if(!$starting_price) disabled @else required @endif/>
                </div>
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size" for="buyout_price">
                        Buyout Price <span class="text-danger">* </span>
                    </label>
                    <input type="number" min="{{ $highest_bid }}" name="buyout_price" id="buyout_price" class="form-control outline-green" value="{{ $auction->buyout_price }}" required/>
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
                    <label class="font-weight-bold font-size" for="color"> Select Color <span class="text-danger">* </span></label>
                    <select id="color" name="color" class="outline-green form-control" required>
                        <option value="" hidden>Select Color</option>
                        <option value="1" @if($auction->id_main_color == '1') selected @endif >Blue</option>     
                        <option value="2" @if($auction->id_main_color == '2') selected @endif >Green</option>     
                        <option value="3" @if($auction->id_main_color == '3') selected @endif >Brown</option>
                        <option value="4" @if($auction->id_main_color == '4') selected @endif >Red</option>
                        <option value="5" @if($auction->id_main_color == '5') selected @endif >Black</option>
                        <option value="6" @if($auction->id_main_color == '6') selected @endif >White</option>
                        <option value="7" @if($auction->id_main_color == '7') selected @endif >Yellow</option>
                        <option value="8" @if($auction->id_main_color == '8') selected @endif >Orange</option>
                        <option value="9" @if($auction->id_main_color == '9') selected @endif >Pink</option>
                        <option value="10" @if($auction->id_main_color == '10') selected @endif >Purple</option>
                        <option value="11" @if($auction->id_main_color == '11') selected @endif >Grey</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size" for="dev_stage"> Select Development Stage <span class="text-danger">* </span></label>
                    <select name="dev_stage" id="dev_stage" class="outline-green form-control" required>
                        <option value="" hidden>Select Development Stage</option>
                        <option value="1" @if($auction->id_dev_stage == '1') selected @endif >Baby</option>
                        <option value="2" @if($auction->id_dev_stage == '2') selected @endif >Child</option>
                        <option value="3" @if($auction->id_dev_stage == '3') selected @endif >Teen</option>
                        <option value="4" @if($auction->id_dev_stage == '4') selected @endif >Adult</option>
                        <option value="5" @if($auction->id_dev_stage == '5') selected @endif >Elderly</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <label for="date-input" class="font-weight-bold font-size">Ending Date <span class="text-danger">* </span></label>
                <input class="form-control outline-green" type="datetime-local" value="{{ (new DateTime($auction->ending_date))->format('Y-m-d\TH:i') }}" min="{{ now()->format('Y-m-d\TH:i') }}" id="date-input" name="ending_date" required>
            </div>
            <div class="col-12 mt-3">
                <label class="font-weight-bold font-size"> Images <span class="text-danger">* </span></label>
                <div class="d-flex flex-row">
                    @isset($photo)
                    <a href="#" class="image_delete w-25 mr-5" data-id="{{ $photo->id }}">
                        <img src="{{url($photo->url)}}" alt="{{url($photo->url)}}" class="w-100">
                    </a>
                    @endisset
                    <div class="custom-file">
                        <input id="animal_picture" type="file" class="form-control" name="animal_picture" required>
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