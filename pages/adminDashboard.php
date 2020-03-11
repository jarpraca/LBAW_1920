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
                        <tr>
                            <th>Reported User</th>
                            <th>Reported By</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="report_inbox">
                        <tr>
                            <td>Steve King</td>
                            <td>Sharapova</td>
                            <td><span class="badge badge-success">Approved</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Steve King</td>
                            <td>Albert Indio</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Albert Indio</td>
                            <td>Sharapova</td>
                            <td><span class="badge badge-danger">Denied</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Steve King</td>
                            <td>Roger Rets</td>
                            <td><span class="badge badge-danger">Denied</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Roger Rets</td>
                            <td>Albert Indio</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Albert Indio</td>
                            <td>Roger Rets</td>
                            <td><span class="badge badge-danger">Denied</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Roger Rets</td>
                            <td>Sharapova</td>
                            <td><span class="badge badge-success">Approved</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Accept Report</a>
                                        <a class="dropdown-item" href="#">Deny Report</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
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
                        <tr>
                            <th>Reported User</th>
                            <th>Status</th>
                            <th>Date of Last Report</th>
                        </tr>
                    </thead>
                    <tbody class="report_inbox">
                        <tr>
                            <td>Steve King</td>
                            <td><span class="badge badge-success">Approved</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Albert Indio</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Roger Rets</td>
                            <td><span class="badge badge-danger">Denied</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sharapova</td>
                            <td><span class="badge badge-danger">Denied</span></td>
                            <td>2019-05-04 19:25</td>
                            <td>
                                <button type="button" class="btn btn-warning">Block</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</section>

<?php


include('../templates/common/footer.php');
?>