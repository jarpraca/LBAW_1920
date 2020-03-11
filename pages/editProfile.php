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

$loggedin = true;
$admin = false;
$signUpPage = false;
$createAuctionPage = true;
$displaySearch = true;

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div class="mainBody">
    <form>
    <h2 class="mt-3 colorGreen mx-auto">Edit Profile</h2>

    <div class="d-flex flex-wrap align-items-center">

            <div class="mx-auto image-container">
                <img class="edit_profile_img"  src="../images/profilePicture.jpg">
                <input id="image_upload" type="file" name="profile_photo" placeholder="Photo" required="" capture>

            </div>
            <div class="mx-auto w-50 align-items-between image-container">
                <div>
                    <label class="font-weight-bold mt-3">Name</label>
                    <input type="text" class="form-control" placeholder="E.g.: John Doe">
                </div>
                <div >
                    <label class="font-weight-bold mt-3" >E-mail</label>
                    <input type="email" class="form-control" placeholder="E.g.: something@fe.up.pt">
                </div>
                <div >
                    <label class="font-weight-bold mt-3" >Password</label>
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <div >
                    <label class="font-weight-bold mt-3">Confirm</label>
                    <input type="password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>
        </div>
        <div id="edit_profile_submit">
            <button type="submit" class="btn btn-green p-2">Save Changes</button>
        </div>
    </form>

    <div class="pt-3"></div>

</div>

<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/editImage.js"></script>