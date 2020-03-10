<section class="mainBody">

    <h1 class="mt-3 colorGreen">Edit Your Auction</h1>

    <form>
        <div class="d-flex flex-row">
            <div class="w-50">
                <h3 class="mt-3"> Name </h3>
                <input type="text" class="form-control outline-green mx-0 w-50" placeholder="Guiné Monkey" />
            </div>
            <div class="w-50">
                <h3 class="mt-3"> Age </h3>
                <input type="text" class="form-control outline-green mx-0 w-50" placeholder="3 years" />
            </div>
        </div>

        <h3 class="mt-3"> Description </h3>
        <textarea name="description" class="form-control borderColorGreen w-100" rows="7">A nice and skilled monkey that loves aerial acrobatics and to climb. It is really friendly and looking for a new home to grow</textarea>


        <div class="form-group">
            <label class="mt-3 font-weight-bold font-size"> Select Category </label>

            <select name="categories" class="outline-green w-25 form-control" required>
                <option value="0" >All</option>
                <option value="1" selected>Mammal</option>
                <option value="2">Insect</option>
                <option value="3">Reptil</option>
                <option value="4">Bird</option>
                <option value="5">Fish</option>
                <option value="6">Amphibian</option>
            </select>
        </div>

        <div class="d-flex flex-row mt-3">
            <div class="w-50">
                <label class="form-check-label my-2 font-weight-bold font-size">
                    Starting Price
                </label>
                <input type="text" class="form-control w-50 outline-green" placeholder="300" />
            </div>
            <div class="w-50">
                <label class="form-check-label my-2 font-weight-bold font-size">
                    Buyout Price
                </label>
                <input type="text" class="form-control w-50 outline-green" placeholder="1050" />
            </div>
        </div>


        <h3 class="mt-3"> Skills </h3>
        <div class="form-row">
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input checked class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Jumps
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Talks
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Skates
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Olfaction
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Moonlight Navigation
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Echolocation
                    </label>
                </div>
                <div class="form-check">
                    <input checked class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Acrobatics
                    </label>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="w-50">
                <label class="mt-3 font-weight-bold font-size"> Select Color </label>
                <select name="colors" class="outline-green w-25 form-control" required>
                    <option value="0">All</option>
                    <option value="1">Blue</option>
                    <option value="2">Green</option>
                    <option value="3" selected>Brown</option>
                    <option value="4">Red</option>
                    <option value="5">Black</option>
                    <option value="6">White</option>
                    <option value="7">Yellow</option>
                </select>
            </div>
            <div class="w-50">
                <label class="mt-3 font-weight-bold font-size"> Select Dev. Stage </label>

                <select name="devStage" class="outline-green w-25 form-control" required>
                    <option value="0">All</option>
                    <option value="1" selected>Baby</option>
                    <option value="2">Child</option>
                    <option value="3">Teen</option>
                    <option value="4">Adult</option>
                    <option value="5">Elderly</option>
                </select>
            </div>
        </div>

        <h3 class="mt-3"> Images </h3>
        <div>
        <img class="w-25" src="../images/mammals.jpg">
            <input type="file" name="picture[]" accept="image/*">
        </div>

        <div class="row justify-content-center">
            <button class="bgColorGreen text-white mx-auto text-center my-3 p-2 w-50" href="#">Save Changes</button>
        </div>
    </form>
    <div class="my-3"></div>
</section>