<section class="mainBody">

    <h1 class="mt-3 colorGreen">Guiné Monkey</h1>

    <div class="d-flex flex-row">
        <h3>Albert&nbsp;&nbsp;&nbsp;&nbsp;3 years</h3>

    </div>
    <div class="d-flex flex-row">
        <div class="w-75">
            <img class="w-100" src="../images/mammals.jpg">
        </div>
        <div class="w-25 text-center d-flex flex-column bgColorGrey ml-4">
            <h2 class="mb-3 mx-auto mt-5">930€</h2>


            <div class="bgColorGreen text-white mx-auto p-2 w-50 popup" onclick="showPopUp()">Bid
                <span class="popuptext" id="myPopup">

                    <button id="close_bt" type="button" class="close mr-2" data-dismiss="modal" aria-label="Close" onclick="hidePopUp()">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h2 class="mt-3">Auction Name</h2>

                    <div class="form-group ml-3 mr-3 mt-3">
                        <select name="categories" class="outline-green form-control" required>
                            <option value="0" selected>Payment Method</option>
                            <option value="1">Debit Card</option>
                            <option value="2">Paypal</option>
                        </select>
                    </div>

                    <div class="form-group ml-3 mr-3 mt-3">
                        <select name="categories" class="outline-green form-control" required>
                            <option value="0" selected>Shipping Method</option>
                            <option value="1">Standard Mail</option>
                            <option value="2">Express Mail</option>
                            <option value="3">Urgent Mail</option>
                        </select>
                    </div>

                    <div class="d-flex ml-2 mr-2 mb-3">
                        <input type="text" class="form-control search_text_input" placeholder="Address" />
                    </div>


                    <button class="btn btn-primary btn-lg" id="submit_bt">SUBMIT</button>


                </span>
            </div>








            <h2 class="mb-3 mx-auto mt-5">Bidding History</h2>
            <div class="d-flex flex-row ml-4">
                <p class="w-50 ml-3 text-left">magicBidder</p>
                <p class="w-50 text-center">910€</p>
            </div>
            <div class="d-flex flex-row ml-4">
                <p class="w-50 ml-3 text-left">dragaoAzul</p>
                <p class="w-50 text-center">890€</p>
            </div>
            <div class="d-flex flex-row ml-4">
                <p class="w-50 ml-3 text-left">jose1960</p>
                <p class="w-50 text-center">870€</p>
            </div>
            <div class="d-flex flex-row ml-4">
                <p class="w-50 ml-3 text-left">maria14</p>
                <p class="w-50 text-center">850€</p>
            </div>
            <div class="d-flex flex-row ml-4">
                <p class="w-50 ml-3 text-left">alvarinho</p>
                <p class="w-50 text-center">830€</p>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mt-3">
        <div class="w-100">
            <h3>Description</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <h3 class="mb-3">Seller</h3>
            <div class="d-flex flex-row my-3">
                <h5>Macaca Industries&nbsp;&nbsp;&nbsp;&nbsp;</h5>
                <h5>2,3 stars</h5>
            </div>
        </div>

    </div>



</section>



<script src="../scripts/bidPopup.js"></script>