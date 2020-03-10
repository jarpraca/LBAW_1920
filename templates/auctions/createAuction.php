<section class="mainBody">

    <h1 class="mt-3 colorGreen">Create Your Auction</h1>

    <form>
        <div class="d-flex flex-row">
            <div class="w-50">
                <h3 class="mt-3"> Name </h3>
                <input type="text" class="form-control search_text_input mx-0 w-50" placeholder="Auction Name" />
            </div>
            <div class="w-50">
                <h3 class="mt-3"> Age </h3>
                <input type="text" class="form-control search_text_input mx-0 w-50" placeholder="Animal Age" />
            </div>
        </div>

        <h3 class="mt-3"> Description </h3>
        <textarea name="description" class="form-control borderColorGreen w-100" rows="7"></textarea>

     
  <div class="form-group">
            <label class="mt-3 font-weight-bold font-size"> Select Category </label>

            <select name="categories" class="outline-green w-25 form-control" required>
                <option value="0" selected>All</option>
                <option value="1" >Mammal</option>
                <option value="2" >Insect</option>
                <option value="3" >Reptil</option>
                <option value="4" >Bird</option>
                <option value="5" >Fish</option>
                <option value="6" >Amphibian</option>
            </select>
        </div>

        <div class="d-flex flex-row mt-3">
            <div class="w-50">
                <input type="text" class="form-control w-50 search_text_input" placeholder="Starting Price" />
            </div>
            <div class="w-50">
                <input type="text" class="form-control w-50 search_text_input" placeholder="Buyout Price" />
            </div>
        </div>


        <h3 class="mt-3"> Skills </h3>
        <div class="form-row">
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs2
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs2
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs2
                    </label>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Climbs2
                    </label>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="w-50">
                <label class="mt-3 font-weight-bold font-size"> Select Color </label>

                <select name="colors" class="btn-green ml-4 w-25 dropdown-menu" required>
                    <option value="0" class="bg-light colorGreen font-weight-bold dropdown-item" selected>All</option>
                    <option value="1" class="bg-light colorGreen font-weight-bold">Blue</option>
                    <option value="2" class="bg-light colorGreen font-weight-bold">Green</option>
                    <option value="3" class="bg-light colorGreen font-weight-bold">Brown</option>
                    <option value="4" class="bg-light colorGreen font-weight-bold">Red</option>
                    <option value="5" class="bg-light colorGreen font-weight-bold">Black</option>
                    <option value="6" class="bg-light colorGreen font-weight-bold">White</option>
                    <option value="7" class="bg-light colorGreen font-weight-bold">Yellow</option>
                </select>
            </div>
            <div class="w-50">
                <label class="mt-3 font-weight-bold font-size"> Select Dev. Stage </label>

                <select name="devStage" class="btn-green ml-4 w-25" required>
                    <option value="0" class="bg-light colorGreen font-weight-bold" selected>All</option>
                    <option value="1" class="bg-light colorGreen font-weight-bold">Baby</option>
                    <option value="2" class="bg-light colorGreen font-weight-bold">Child</option>
                    <option value="3" class="bg-light colorGreen font-weight-bold">Teen</option>
                    <option value="4" class="bg-light colorGreen font-weight-bold">Adult</option>
                    <option value="5" class="bg-light colorGreen font-weight-bold">Elderly</option>
                </select>
            </div>
        </div>

        <h3 class="mt-3"> Images </h3>
        <div>
            <input type="file" name="picture[]" accept="image/*">
        </div>

        <button class="bgColorGreen text-white mx-auto my-3 p-2 w-50" href="#">Create Auction</button>
    </form>
    <div class="my-3"></div>
</section>