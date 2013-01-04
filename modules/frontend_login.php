<?php
/* Handle the return value from the functions in login_common.php.
   This is to be considered site specific, as it may redirect the user
   around to other pages or produce other output.

   MUST be called before any page output.
 */
function frontend_handle_login($ret)
{
  require_once 'frontend_urls.php';

  $stat = $ret['status'];

  /* TODO: All of these cases will be expanded with addition
     functionality later. In cases where info from $ret needs to be
     passed on to other pages, use session variables.
   */

  if($stat == "ok") redirect_session();
  elseif($stat == "already")
    {
      echo "You are already logged in!";
    }
  elseif($stat == "nouser")
    {
      echo "No user found. User creation is not implemented yet";
    }
  elseif($stat == "error")
    {
      echo "Error: " . $ret['error'];
    }
  else
    {
      echo "Something went wrong. Details:<br>";
      print_r($ret);
    }
}
?>