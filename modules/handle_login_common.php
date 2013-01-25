<?php
function createUserFromAuth($auth)
{
  require_once 'db_user.php';

  $id = db_addUser();
  db_addAuthEntry($auth,$id);
  return $id;
}

/* Sign in using an auth string. See description of login_email() for
   more details.
 */
function login_auth($auth, $keep)
{
  require 'db_auth.php';

  $ret = array("auth" => $auth,
               "keep" => $keep);

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
  require 'auth_code.php';

  if($email == "")
    die("Missing email");

  // Encode the auth string and let login_auth() handle it.
  return login_auth(auth_encode_email($email), $keep);
}

/* Handle return value from the login functions.

   The 'url' is where to redirect on a successful login.
 */
function handle_login_ret($ret, $url)
{
  $stat = $ret['status'];

  if($stat == "nouser")
    {
      /* The user didn't exist. Auto-create a new account based on the
         identification they just provided.
      */
      $auth = $ret['auth'];
      $id = createUserFromAuth($auth);

      // Log in as the new user
      $ret2 = login_auth($auth, $ret['keep']);

      if($ret2['userid'] == $id && $ret2['status'] == "ok")
        $stat == "ok";
    }

  if($stat == "ok")
    header("Location: $url");

  /* This error will never happen, so don't bother prettying it up.
   */
  die("Something went wrong. We are completely at a loss as to why. Maybe it's just not your lucky day.");
}
?>