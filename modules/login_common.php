<?php
require 'login_externals.php';
require 'auto_login.php';
require 'auth_code.php';
require 'db_auth.php';

/* Sign in using an auth string. See description of login_email() for
   more details.
 */
function _login_auth($auth, $keep)
{
  global $g_loggedIn;

  $ret = array("auth" => $auth,
               "keep" => $keep);

  if($g_loggedIn)
    {
      // Tell the caller that we are already logged in
      $ret['status'] = "already";
      return $ret;
    }

  // Find the user associated
  $userid = db_getUserFromAuth($auth);
  if($userid == "")
    {
      $ret['status'] = "nouser";
      return $ret;
    }

  // Log the user in and exit
  doLogin($userid, $keep);

  $ret['userid'] = $userid;
  $ret['status'] = "ok";
  return $ret;
}

/* Sign the user in using an email address. Assumes the email is
   CONFIRMED to belong to this user.

   Returns a data table with detailed info about how it went.
 */
function login_email($email, $keep)
{
  if($email == "")
    return array("status" => "error",
                 "error" => "Missing or invalid email");

  // Encode the auth string and let _login_auth() handle it.
  return _login_auth(auth_encode_email($email));
}
?>