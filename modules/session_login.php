<?php
/* Check whether a user currently has login data, either through
   cookies or session variables. Should only be called once at the
   beginning of the script.

   Returns login info in a table.

   NOTE: This has not yet CONFIRMED any data, nor is the data
   sanitized. Assume the returned values are malicious.
 */
function get_login_info()
{
  session_start();

  $ret = array();
  $ret['logged_in'] = false;

  // Check for session information
  if(!isset($_SESSION['userid']) || !isset($_SESSION['key']))
    {
      // No session. Maybe there are some tasty cookies for us?
      if(isset($_COOKIE['userid']) && isset($_COOKIE['key']))
        {
          // Yes. Copy it to the current session.
          $_SESSION['userid'] = $_COOKIE['userid'];
          $_SESSION['key']    = $_COOKIE['key'];
          $ret['source'] = 'cookie';
        }
      else
        // No login info found.
        return $ret;
    }
  else
    {
      $ret['source'] = 'session';
    }

  // Return session data
  assert(isset($_SESSION['userid']) && isset($_SESSION['key']));
  $ret['logged_in'] = true;
  $ret['userid'] = $_SESSION['userid'];
  $ret['key']    = $_SESSION['key'];
  return $ret;
}

/* Clear cookie and session info, essentially "logging out". Note that
   this doesn't actually remove the user's authentication, it just
   tells them to stop using the info. You also have to invalidate the
   $userid/$key pair as valid credentials on your end.

   Has to be called before any page output for cookies to take effect.
 */
function clear_login_info()
{
  // Delete cookies
  setcookie("userid", "", time() - 60*60*24*100);
  setcookie("key",    "", time() - 60*60*24*100);

  // Kill the session data
  session_destroy();
}

/* Set current login info. This essentially "logs us in", and stores
   session and cookie info for future calls to get_login_info().
   Cookies are only stored if 'keep' is true. The 'expire' parameter
   gives the cookie lifetime in seconds (default is 100 days.)

   This has to be called as the FIRST output of a page, otherwise the
   cookies will not work.
 */
function set_login_info($userid, $key, $keep, $expire = 8640000)
{
  // Clear any existing contents first
  clear_login_info();
  session_start();

  // Set up the session to be 'logged in' from this point on.
  $_SESSION['userid'] = $userid;
  $_SESSION['key'] = $key;

  if($keep)
    {
      setcookie("userid", $userid, time() + $expire);
      setcookie("key",    $key,    time() + $expire);
    }
}
?>