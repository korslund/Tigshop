<?php
require 'session_login.php';
require 'db_login.php';

/* Check if the user is currently logged in, and if so return the user
   id through the reference parameter.

   This is auto-called below, you will never need to call it manually.
 */
function internal_isLoggedIn(&$userid)
{
  $userid = "";

  // Get session and cookie data, if any
  $info = get_login_info();

  if($info['logged_in'])
    {
      $userid = $info['userid'];
      $passkey = $info['key'];

      // Check against the database
      if(db_checkLogin($userid, $passkey))
        {
          // Approved.
          $userid = $userid;
          return true;
        }
    }

  return false;
}

/* Call when the user has authenticated and you are ready to log them
   in. Has to be called before any page output, as it sets cookies.

   Note that the userid has to be 32 characters or less (numbers
   should work fine.)

   The 'keep' parameter determines whether the user should stay logged
   in after the current session.
 */
function doLogin($userid, $keep)
{
  // Insert into the database, and get a generated key
  $pass = db_addLogin($userid);

  // Bake a cookie
  set_login_info($userid, $pass, $keep);
}

/* Invalidate any login authentication associated with the given
   userid. This essentially logs them out. Like doLogin(), this should
   be called before any page output.
 */
function doLogout($userid)
{
  // Kill database entry
  db_removeLogin($userid);

  // Killing session/cookie info isn't strictly necessary (with the DB
  // entry gone, the info becomes useless), but do it anyway.
  clear_login_info();
}

// Global data.
$g_userid = "";
$g_loggedIn = internal_isLoggedIn($g_userid);
?>