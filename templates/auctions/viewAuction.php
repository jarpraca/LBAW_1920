<section class="mainBody">

    <h1 class="mt-3 colorGreen">Guiné Monkey</h1>

    <div class="d-flex flex-row">
        <h3>Albert&nbsp;&nbsp;&nbsp;&nbsp;3 years</h3>

    </div>

    <div class="d-flex flex-wrap">
        <div class="imgAuction">
            <img class="w-100" src="../images/mammals.jpg">
        </div>

        <div class=" text-center d-flex flex-column bgColorGrey bid-bar">
            <h2 class="mb-3 mx-auto mt-5">930€</h2>
            <?php
            if ($isOwner) {
            ?>
                <a class="btn btn-green mx-3" href="editAuction.php">Edit Auction</a>
                <a class="btn btn-green mt-3  mx-3" href="#">Delete Auction</a>

            <?php
            } else if ($isAdmin) {
            ?>

                <a class="btn btn-green mt-3  mx-3" href="#">Stop Auction</a>
                <a class="btn btn-green mt-3  mx-3" href="#">Delete Content</a>

            <?php } else if ($isUser) { ?>

                <div class="d-flex flex-row mx-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <<div class="bgColorGreen text-white mx-auto p-2 w-50 popup" onclick="showPopUp()">Bid
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
                </div>
                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="#">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="#">Report</a>

            <?php } else { ?>

                <div class="d-flex flex-row mx-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
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
                </div>
                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="signup.php">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="signup.php">Report</a>

            <?php } ?>

            <h2 class="mb-3 mx-auto mt-5">Bidding History</h2>

            <div class="overflow-auto h-25">
                <div class="d-flex flex-row ml-4 ">
                    <p class="w-50 ml-3 text-left ">Steve King</p>
                    <p class="w-50 text-center ">910€</p>
                </div>
                <div class="d-flex flex-row ml-4">
                    <p class="w-50 ml-3 text-left ">Albert Indio</p>
                    <p class="w-50 text-center ">890€</p>
                </div>
                <div class="d-flex flex-row ml-4">
                    <p class="w-50 ml-3 text-left ">Sharapova</p>
                    <p class="w-50 text-center ">870€</p>
                </div>
                <div class="d-flex flex-row ml-4">
                    <p class="w-50 ml-3 text-left ">Roger Rets</p>
                    <p class="w-50 text-center ">850€</p>
                </div>
                <div class="d-flex flex-row ml-4">
                    <p class="w-50 ml-3 text-left ">Paul Love</p>
                    <p class="w-50 text-center ">830€</p>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mt-3">
        <div class="w-100">
            <h3>Description</h3>
            <p>A nice and skilled monkey that loves aerial acrobatics and to climb. It is really friendly and looking for a new home to grow</p>
            <h3 class="mb-3">Seller</h3>
            <div class="d-flex flex-row my-3 align-items-center">
                <img class="rounded-circle mr-2 cover" width="70px" height="70px" src="../images/mammals.jpg">
                <h5 class="font-weight-bold">Macaca Industries&nbsp;&nbsp;&nbsp;&nbsp;</h5>
                <h5>2,3 stars</h5>
            </div>
        </div>

    </div>



</section>



<script src="../scripts/bidPopup.js"></script>