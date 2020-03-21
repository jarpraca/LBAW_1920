<?php
function generate_random_token()
{
    return bin2hex(openssl_random_pseudo_bytes(32));
}
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}
// if (isset($_SESSION['user']))
$loggedin = true;
$displaySearch = true;
$createAuctionPage = false;
$signupPage = false;
$admin = false;

include('../templates/common/header.php');
?>

<section class="mainBody mb-3">


    <h1 class="mt-3 mb-3 colorGreen">Admin Dashboard</h1>


    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">Report Inbox</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-4 col-sm-3">Reported User</th>
                            <th class="col-4 col-sm-3">Reported By</th>
                            <th class="col-3 col-sm-2">Status</th>
                            <th class="col-4 col-sm-2">Date</th>
                            <th class="col-4 col-sm-2"></th>
                        </tr>
                    </thead>
                    <tbody class="report_inbox">
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Steve King</td>
                            <td class="col-4 col-sm-3">Sharapova</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-success py-2">Approved</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                             
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Steve King</td>
                            <td class="col-4 col-sm-3">Albert Indio</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-warning py-2">Pending</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <div class="dropdown show">
                                    <a class="btn btn-outline-green dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Albert Indio</td>
                            <td class="col-4 col-sm-3">Sharapova</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-danger py-2 ">Denied</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                               
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Steve King</td>
                            <td class="col-4 col-sm-3">Roger Rets</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-danger py-2">Denied</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                              
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Roger Rets</td>
                            <td class="col-4 col-sm-3">Albert Indio</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-warning py-2">Pending</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <div class="dropdown show">
                                    <a class="btn btn-outline-green dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Albert Indio</td>
                            <td class="col-4 col-sm-3">Roger Rets</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-danger py-2">Denied</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                               
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-4 col-sm-3">Roger Rets</td>
                            <td class="col-4 col-sm-3">Sharapova</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-success py-2 ">Approved</span></td>
                            <td class="col-4 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                             
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2 mt-sm-0 d-flex flex-row justify-content-center">
                    <li class="page-item"><a class="page-link colorGreen " href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link colorGreen " href="#">1</a></li>
                    <li class="page-item"><a class="page-link colorGreen font-weight-bolder" href="#">2</a></li>
                    <li class="page-item"><a class="page-link colorGreen " href="#">3</a></li>
                    <li class="page-item"><a class="page-link colorGreen " href="#">Next</a></li>
                </ul>
            </nav>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->



    <div class="card mt-5">
        <div class="card-header border-transparent">
            <h3 class="card-title">Block and Delete Users</h3>

            <form class="form-inline ml-3 py-2 my-lg-0">
                <input class="form-control w-50 mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-green2 my-2 my-sm-0" type="submit">Search</button>
            </form>

        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-5 col-sm-2">Reported User</th>
                            <th class="col-3 col-sm-2">Status</th>
                            <th class="col-5 col-sm-2">Date of Last Report</th>
                            <th class="col-4 col-sm-2"></th>
                        </tr>
                    </thead>
                    <tbody class="report_inbox">
                        <tr class="d-flex">
                            <td class="col-5 col-sm-2">Steve King</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-success py-2">Approved</span></td>
                            <td class="col-5 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger mt-2 mt-sm-0">Delete</button>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-5 col-sm-2">Albert Indio</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-warning py-2">Pending</span></td>
                            <td class="col-5 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger mt-2 mt-sm-0">Delete</button>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-5 col-sm-2">Roger Rets</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-danger py-2">Denied</span></td>
                            <td class="col-5 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger mt-2 mt-sm-0">Delete</button>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-5 col-sm-2">Sharapova</td>
                            <td class="col-3 col-sm-2"><span class="badge badge-danger py-2">Denied</span></td>
                            <td class="col-5 col-sm-2">2019-05-04 19:25</td>
                            <td class="col-4 col-sm-2">
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger mt-2 mt-sm-0">Delete</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2 mt-sm-0 d-flex flex-row justify-content-center">
                    <li class="page-item"><a class="page-link colorGreen " href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link colorGreen font-weight-bolder" href="#">1</a></li>
                    <li class="page-item"><a class="page-link colorGreen " href="#">2</a></li>
                    <li class="page-item"><a class="page-link colorGreen " href="#">Next</a></li>
                </ul>
            </nav>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</section>

<?php


include('../templates/common/footer.php');
?>