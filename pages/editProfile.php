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

$logedin = false;
$displaySearch = true;

if (isset($_SESSION['user']))
    $logedin = true;

include('../templates/common/header.php');
?>
<div class="mainBody" id="edit_profile">
    <form>
        <h2>Edit Profile</h2>
        <div id="edit_profile_top">

            <div id="edit_profile_img">
                <img id="profile_img" src="../images/profilePicture.jpg">
            </div>
            <input id="image_upload" type="file" name="profile_photo" placeholder="Photo" required="" capture>
            <div id="edit_profile_info">
                <div id="edit_profile_name">
                    <label class="edit_profile_info_title">Name</label>
                    <input type="text" class="edit_profile_info_content" placeholder="eg.John Doe">
                </div>
                <div id="edit_profile_email">
                    <label class="edit_profile_info_title">E-mail</label> 
                    <input type="email" class="edit_profile_info_content" placeholder="eg.something@fe.up.pt">
                </div>
                <div id="edit_profile_password">
                    <label class="edit_profile_info_title">Password</label>
                    <input type="password" class="edit_profile_info_content" placeholder="password">
                </div>
                <div id="edit_profile_confirm">
                    <label class="edit_profile_info_title">Confirm</label> 
                    <input type="password" class="edit_profile_info_content" placeholder="confirm password">
                </div>
            </div>
        </div>
        <div id="edit_profile_submit">
            <button type="submit">Submit</button>
        </div>
    </form>

</div>

<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/editImage.js"></script>