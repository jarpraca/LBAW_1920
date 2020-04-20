@extends('layouts.app')

@section('title', 'Create Auction')

@section('content')
<div class="bg-white pt-4">
    <section class="mainBody align-items-center justify-content-center">
        <form class="createAuction mx-auto" method="POST" action="{{ route('auctions', ['id' => Auth::id()]) }}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col">
                <h1 class="mt-3 colorGreen mx-auto">Create Your Auction</h1>
            </div>
            @if (session('error'))
            <div class="alert alert-danger my-4">{{ session('error') }}</div>
            @endif
            <div class="d-flex flex-wrap mt-3">
                <div class="col-12 col-sm-6">
                    <h3> Species Name </h3>
                    <input type="text" name="species_name" class="form-control outline-green mx-0" placeholder="E.g.: Guinea Monkey" value="{{ old('species_name') }}" />
                </div>
                <div class="col-12 col-sm-6">
                    <h3> Name </h3>
                    <input type="text" name="name" class="form-control outline-green mx-0" placeholder="E.g.: Albert" value="{{ old('name') }}" />
                </div>
            </div>

            <div class="d-flex flex-row">
                <div class="col">
                    <h3 class="mt-3"> Description </h3>
                    <textarea name="description" id="description" class="form-control borderColorGreen w-100" rows="7" value="{{ old('description') }}"></textarea>
                </div>
            </div>
            <div class="form-group d-flex flex-row mt-3">
                <div class="col">
                    <label class="font-weight-bold font-size"> Select Category </label>
                    <select name="category" id="category" class="outline-green form-control" value="" required>
                        <option value="0" hidden></option>
                        <option value="1">Mammal</option>
                        <option value="2">Insect</option>
                        <option value="3">Reptile</option>
                        <option value="5">Bird</option>
                        <option value="4">Fish</option>
                        <option value="6">Amphibian</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size"> Age </label>
                    <input type="text" name="age" class="form-control outline-green" placeholder="E.g.: 3 years" value="{{ old('age') }}" />
                </div>
            </div>

            <div class="d-flex flex-row mt-4">
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size">
                        Starting Price
                    </label>
                    <input type="text" name="starting_price" class="form-control outline-green" placeholder="E.g.: 300€" value="{{ old('starting_price') }}" />
                </div>
                <div class="col">
                    <label class="form-check-label font-weight-bold font-size">
                        Buyout Price
                    </label>
                    <input type="text" name="buyout_price" class="form-control outline-green" placeholder="E.g.: 1000€" value="{{ old('buyout_price') }}" />
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
                    <select id="color" name="color" class="outline-green form-control" value="{{ old('color') }}" required>
                        <option value="0" hidden></option>
                        <option value="1">Blue</option>
                        <option value="2">Green</option>
                        <option value="3">Brown</option>
                        <option value="4">Red</option>
                        <option value="5">Black</option>
                        <option value="6">White</option>
                        <option value="7">Yellow</option>
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold font-size"> Select Dev. Stage </label>

                    <select name="dev_stage" id="dev_stage" class="outline-green form-control" value="{{ old('dev_Stage') }}" required>
                        <option value="0" hidden></option>
                        <option value="1">Baby</option>
                        <option value="2">Child</option>
                        <option value="3">Teen</option>
                        <option value="4">Adult</option>
                        <option value="5">Elderly</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-row mt-4">
                <div class="col-12 col-sm-6">
                    <label for="date-input" class="font-weight-bold font-size">Date</label>
                    <input class="form-control outline-green" type="date" value="2011-08-19" id="date-input" name="ending_date">
                </div>
                <div class="col-12 col-sm-6">
                    <label class="font-weight-bold font-size"> Images </label>
                    <div class="custom-file">
                        <input id="animal_picture" type="file" class="form-control" name="animal_picture">
                        <label class="custom-file-label" for="animal_picture" id="customFileLabel">Add Photo</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button class="btn btn-green text-white mx-auto text-center mt-5" type="submit">Create Auction</button>
            </div>
        </form>
        <div class="py-3"></div>
    </section>
</div>
@endsection