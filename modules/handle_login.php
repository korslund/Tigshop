<?php
require 'auto_login.php';
require 'nonce.php';

if($g_loggedIn)
  {
    if(isset($_GET['logout']) && $_GET['logout'] == $g_userid)
      {
        doLogout($g_userid);

        require 'frontend_urls.php';

        // Redirect home if the caller requested it
        if(isset($_GET['gohome']))
          redirect_home();

        // Otherwise, redirect back to the same page
        require_once 'urltools.php';
        $newURL = url_remove_get(get_this_url(), "logout");
        do_redirect($newURL);
      }
  }
else
  {
    // Check for incomming OpenID login
    if(isset($_GET['openid_mode']))
      {
        require 'handle_openid.php';
        exit;
      }

    // Check for validation code
    if(isset($_GET['login_code']))
      {
        require 'handle_code.php';
        exit;
      }

    // Check for login form values
    if(isset($_POST['login_type']) && tg_checkNoncePOST("login_nonce"))
      {
        $tp = $_POST['login_type'];
        if($tp == "google")
          {
            require_once 'login_openid.php';
            login_google(DOMAIN_NAME);
            die("Internal error: did not redirect to Google as expected");
          }
        elseif($tp == "email")
          {
            $email = $_POST['email'];
            require_once 'db_code.php';
            require_once 'auth_code.php';
            require_once 'urltools.php';
            $code = db_addLoginCode(auth_encode_email($email));

            $url = get_this_url();
            $url = url_add_get($url,"login_code","$code");

            $body = "Hi, here is your login link from Tigshop!\n\nThis link will log you in as $email. Don't have an account? Don't worry! Our legion of magical gnomes will set one up for you automatically.\n\nSign in: $url\n\n(If the link is not clickable, try copy-pasting it into your web browser.)\n\nBest regards,\nThe Tigshop Gnomes";

            mail($email, "Sign In to TigShop", $body, "From: noreply@tiggit.net");

            // TODO: we need something better than this
            die("The magic email fairy has sent you an email!");
          }
        else
          die("Invalid login parameters!");
      }
  }
?>