<?php
require '../modules/db_code.php';
require '../modules/nonce.php';
require_once '../modules/frontend_urls.php';
require '../modules/auth_code.php';

tg_requireNoncePOST("login_nonce");

if(isset($_GET['redir']))
  redirect_set_session($_GET['redir']);

// TODO: Sanitation
$email = $_POST['email'];

// Create a code and login url
$code = db_addLoginCode(auth_encode_email($email));
$url = url_login().'code.php?code='.$code;

// Send email
$body = "Hi, here is your login link from TigShop!\n\nThis link will log you in as $email. If this account does not exist, our legion of tiny magical gnomes will rush to set it up for you automatically.\n\nSign in here: $url\n\nHint: If the link is not clickable, try copy-pasting it into the address bar of your web browser! The code is valid for 24 hours.\n\nBest regards,\nThe tigshop gnomes";

mail($email, "Sign In to TigShop", $body, "From: noreply@tiggit.net");
echo "<p>A login link has been sent to $email.</p>";
?>
