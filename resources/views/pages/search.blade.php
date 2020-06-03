@extends('layouts.app')

@section('title', $search == "" ? 'Search results' : 'Searched for "'. $search . '"')

@section('content')

<meta property="og:title" content="BidMonkeys- Your animal auction website" />
<meta property="og:description" content="Need to find the perfect animal, this is the spot!" />
<meta property="og:image" content="{{asset('assets/logo.png')}}" />
<meta property="og:locale" content="en_GB" />

<div class="bg-white pt-4">
    <section class="mainBody">
        @if (session('error'))
        <div class="alert alert-danger my-4">{{ session('error') }}</div>
        @endif
        <div class="bgColorGrey">

            <form method="GET" action="{{ route('search') }}">
                <div class="navbar-search form-inline mx-auto no-print">
                    <label style="display:none" for="search">Search</label>
                    <input class="form-control" type="search" id="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search }}">
                    <button class="btn btn-green2 my-2 my-sm-0" type="submit">Search</button>
                </div>

                <div class="d-flex flex-wrap no-print" id="accordion">
                    <div class="mx-auto">
                        <p class="justify-content-between">
                            <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#categories" role="button" aria-expanded="false" aria-controls="categories">
                                Category
                            </a>
                            <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#colors" role="button" aria-expanded="false" aria-controls="colors">
                                Color
                            </a>
                            <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#price" role="button" aria-expanded="false" aria-controls="price">
                                Price
                            </a>
                            <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#devStage" role="button" aria-expanded="false" aria-controls="devStage">
                                Dev. Stage
                            </a>
                            <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#skills" role="button" aria-expanded="false" aria-controls="skills">
                                Skills
                            </a>
                        </p>
                        <div class="collapse" id="categories" data-parent="#accordion">
                            <div class="card card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="mammals" type="checkbox" id="mammals">
                                            <label class="form-check-label font-size" for="mammals">
                                                Mammals
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="insects" type="checkbox" id="insects">
                                            <label class="form-check-label font-size" for="insects">
                                                Insects
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="reptiles" type="checkbox" id="reptiles">
                                            <label class="form-check-label font-size" for="reptiles">
                                                Reptiles
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="birds" type="checkbox" id="birds">
                                            <label class="form-check-label font-size" for="birds">
                                                Birds
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="fishes" type="checkbox" id="fishes">
                                            <label class="form-check-label font-size" for="fishes">
                                                Fishes
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="amphibians" type="checkbox" id="amphibians">
                                            <label class="form-check-label font-size" for="amphibians">
                                                Amphibians
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="colors" data-parent="#accordion">
                            <div class="card card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="blue" type="checkbox" id="blue">
                                            <label class="form-check-label font-size" for="blue">
                                                Blue
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="green" type="checkbox" id="green">
                                            <label class="form-check-label font-size" for="green">
                                                Green
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="brown" type="checkbox" id="brown">
                                            <label class="form-check-label font-size" for="brown">
                                                Brown
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="red" type="checkbox" id="red">
                                            <label class="form-check-label" for="red">
                                                Red
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="black" type="checkbox" id="black">
                                            <label class="form-check-label font-size" for="black">
                                                Black
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="white" type="checkbox" id="white">
                                            <label class="form-check-label font-size" for="white">
                                                White
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="yellow" type="checkbox" id="yellow">
                                            <label class="form-check-label font-size" for="yellow">
                                                Yellow
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="grey" type="checkbox" id="grey">
                                            <label class="form-check-label font-size" for="grey">
                                                Grey
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="price" data-parent="#accordion">
                            <div class="card card-body">
                                <div class="d-flex flex-wrap justify-space-between">
                                    <div class="col">
                                        <div class="form-check row">
                                            <label class="form-check-label font-size" for="min_price">
                                                Minimum Price
                                            </label>
                                            <input class="form-control w-75 outline-green" type="number" id="min_price" name="min_price">

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check row">
                                            <label class="form-check-label font-size" for="max_price">
                                                Maximum Price
                                            </label>
                                            <input class="form-control  w-75 outline-green" type="number" id="max_price" name="max_price">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="devStage" data-parent="#accordion">
                            <div class="card card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="baby" type="checkbox" id="baby">
                                            <label class="form-check-label font-size" for="baby">
                                                Baby
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="child" type="checkbox" id="child">
                                            <label class="form-check-label font-size" for="child">
                                                Child
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="teen" type="checkbox" id="teen">
                                            <label class="form-check-label font-size" for="teen">
                                                Teen
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="adult" type="checkbox" id="adult">
                                            <label class="form-check-label font-size" for="adult">
                                                Adult
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="elderly" type="checkbox" id="elderly">
                                            <label class="form-check-label font-size" for="elderly">
                                                Elderly
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="skills" data-parent="#accordion">
                            <div class="card card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="climbs" type="checkbox" id="climbs">
                                            <label class="form-check-label font-size" for="climbs">
                                                Climbs
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="jumps" type="checkbox" id="jumps">
                                            <label class="form-check-label font-size" for="jumps">
                                                Jumps
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="talks" type="checkbox" id="talks">
                                            <label class="form-check-label font-size" for="talks">
                                                Talks
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="skates" type="checkbox" id="skates">
                                            <label class="form-check-label font-size" for="skates">
                                                Skates
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="olfaction" type="checkbox" id="olfaction">
                                            <label class="form-check-label font-size" for="olfaction">
                                                Olfaction
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="navigation" type="checkbox" id="navigation">
                                            <label class="form-check-label font-size" for="navigation">
                                                Navigation
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-check row">
                                            <input class="form-check-input" name="echo" type="checkbox" id="echo">
                                            <label class="form-check-label font-size" for="echo">
                                                Echolocation
                                            </label>
                                        </div>
                                        <div class="form-check row">
                                            <input class="form-check-input" name="acrobatics" type="checkbox" id="acrobatics">
                                            <label class="form-check-label font-size" for="acrobatics">
                                                Acrobatics
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>

        @if(sizeof($auctions) != 0)
        <div class="mb-5">
            <div class="d-flex flex-wrap">
                @each('partials.card', $auctions, 'auction')
            </div>
            <div class="d-flex justify-content-center w-100">
            {{ $auctions->links() }}
            </div>
        </div>
        @else
        <div class="d-flex justify-content-center mt-5">
            <h4>No results</h4>
        </div>
        @endif
    </section>
</div>
@endsection