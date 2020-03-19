<section class="mainBody align-items-center justify-content-center">
    <form class="editAuction mx-auto">
        <div class="col">
            <h1 class="mt-3 colorGreen mx-auto">Create Your Auction</h1>
        </div>
        <div class="d-flex flex-wrap mt-3">
            <div class="col-12 col-sm-6">
                <h3> Species Name </h3>
                <input type="text" class="form-control outline-green mx-0" placeholder="E.g.: Guinea Monkey" value="<?php $speciesName ?>"/>
            </div>
            <div class="col-12 col-sm-6">
                <h3> Name </h3>
                <input type="text" class="form-control outline-green mx-0" placeholder="E.g.: Albert" value="<?php $name ?>"/>
            </div>
        </div>

        <div class="d-flex flex-row">
            <div class="col">
                <h3 class="mt-3"> Description </h3>
                <textarea name="description" class="form-control borderColorGreen w-100" rows="7" value="<?php $description ?>"></textarea>
            </div>
        </div>
        <div class="form-group d-flex flex-row mt-3">
            <div class="col">
                <label class="font-weight-bold font-size"> Select Category </label>
                <select name="categories" class="outline-green form-control" value="<?php $category ?>" required>
                    <option value="0" hidden></option>
                    <option value="1">Mammal</option>
                    <option value="2">Insect</option>
                    <option value="3">Reptile</option>
                    <option value="4">Bird</option>
                    <option value="5">Fish</option>
                    <option value="6">Amphibian</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold font-size"> Age </label>
                <input type="text" class="form-control outline-green" placeholder="E.g.: 3 years" value="<?php $age ?>"/>
            </div>
        </div>

        <div class="d-flex flex-row mt-3">
            <div class="col">
                <label class="form-check-label font-weight-bold font-size">
                    Starting Price
                </label>
                <input type="text" class="form-control outline-green" placeholder="E.g.: 300€" value="<?php $startingPrice ?>"/>
            </div>
            <div class="col">
                <label class="form-check-label font-weight-bold font-size">
                    Buyout Price
                </label>
                <input type="text" class="form-control outline-green" placeholder="E.g.: 1000€" value="<?php $buyoutPrice ?>"/>
            </div>
        </div>

        <div class="d-flex flex-row mt-3">
            <div class="col">
                <h3 class="mt-3"> Skills </h3>
                <div class="d-flex flex-wrap">
                    <div class="col-6 col-sm-3">
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Climbs
                            </label>
                        </div>
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Jumps
                            </label>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Talks
                            </label>
                        </div>
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Skates
                            </label>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Olfaction
                            </label>
                        </div>
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Moonlight Navigation
                            </label>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Echolocation
                            </label>
                        </div>
                        <div class="form-check row">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
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
                <select name="colors" class="outline-green form-control" value="<?php $color ?>" required>
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

                <select name="devStage" class="outline-green form-control" value="<?php $devStage ?>" required>
                    <option value="0" hidden></option>
                    <option value="1">Baby</option>
                    <option value="2">Child</option>
                    <option value="3">Teen</option>
                    <option value="4">Adult</option>
                    <option value="5">Elderly</option>
                </select>
            </div>
        </div>

        <div class="d-flex flex-row mt-3">
            <div class="col-12 col-sm-6">
                <h3> Images </h3>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="picture[]" accept="image/*" multiple>
                    <label class="custom-file-label" for="customFile" id="customFileLabel">Add Photo</label>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <a class="btn btn-green text-white mx-auto text-center mt-5" href="viewAuctionOwner.php">Create Auction</a>
        </div>
    </form>
    <div class="my-3"></div>
</section>