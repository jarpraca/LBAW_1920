<section class="mainBody">

    <h1 class="mt-3 colorGreen">Guinea Monkey</h1>

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
            } else if ($admin) {
            ?>

                <a class="btn btn-green mt-3  mx-3" href="#">Stop Auction</a>
                <a class="btn btn-green mt-3  mx-3" href="#">Delete Content</a>

            <?php } else if ($isUser) { ?>

                <div class="d-flex flex-row mx-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="#">Bid</a>
                </div>
                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="#">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="#">Report</a>
                <a class="btn btn-green mt-3  mx-3" href="#">Add to Watchlist</a>

            <?php } else { ?>

                <div class="d-flex flex-row mx-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="signup.php">Bid</a>

                </div>
                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="signup.php">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="signup.php">Report</a>
                <a class="btn btn-green mt-3  mx-3" href="signup.php">Add to Watchlist</a>

            <?php } ?>

            <h2 class="mb-3 mx-auto mt-5">Bidding History</h2>

            <div class="h-25">
                <div class="d-flex flex-row ml-4 mb-0">
                    <p class="w-50 ml-3 text-left mb-0 ">Steve King</p>
                    <p class="w-50 text-center mb-0">910€</p>
                </div>
                <div class="d-flex flex-row ml-4 mb-0">
                    <p class="w-50 ml-3 text-left mb-0">Albert Indio</p>
                    <p class="w-50 text-center mb-0">890€</p>
                </div>
                <div class="d-flex flex-row ml-4 mb-0">
                    <p class="w-50 ml-3 text-left mb-0">Sharapova</p>
                    <p class="w-50 text-center mb-0">870€</p>
                </div>
                <div class="d-flex flex-row ml-4 mb-0">
                    <p class="w-50 ml-3 text-left mb-0 ">Roger Rets</p>
                    <p class="w-50 text-center mb-0">850€</p>
                </div>
                <div class="p-2 popup" data-toggle="modal" data-target="#bidsModal">
                <p class="colorGreen text-decoration-underline mx-auto"><u>See More</u></p>  
                </div>
                <div class="modal fade" id="bidsModal" role="dialog" aria-labelledby="bidsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content mx-auto">
                            <div class="modal-header">
                                <h2 class="mt-3">Bidding History</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="overflow-auto h-75">
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Steve King</p>
                                        <p class="w-50 text-center mb-0">910€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Albert Indio</p>
                                        <p class="w-50 text-center mb-0">890€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Sharapova</p>
                                        <p class="w-50 text-center mb-0">870€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Roger Rets</p>
                                        <p class="w-50 text-center mb-0">850€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Steve King</p>
                                        <p class="w-50 text-center mb-0">830€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Albert Indio</p>
                                        <p class="w-50 text-center mb-0">810€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Sharapova</p>
                                        <p class="w-50 text-center mb-0">790€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Roger Rets</p>
                                        <p class="w-50 text-center mb-0">770€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Steve King</p>
                                        <p class="w-50 text-center mb-0">750€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Albert Indio</p>
                                        <p class="w-50 text-center mb-0">730€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Sharapova</p>
                                        <p class="w-50 text-center mb-0">710€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Roger Rets</p>
                                        <p class="w-50 text-center mb-0">690€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Steve King</p>
                                        <p class="w-50 text-center mb-0">670€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Albert Indio</p>
                                        <p class="w-50 text-center mb-0">650€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0">Sharapova</p>
                                        <p class="w-50 text-center mb-0">630€</p>
                                    </div>
                                    <div class="d-flex flex-row ml-4 mb-0">
                                        <p class="w-50 ml-3 text-left mb-0 ">Roger Rets</p>
                                        <p class="w-50 text-center mb-0">610€</p>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mt-3">
        <div class="w-75">
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