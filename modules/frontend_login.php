<?php

/* Handle the return value from the functions in login_common.php.
   This is to be considered site specific, as it may redirect the user
   around to other pages or produce other output.
 */
function frontend_handle_login($ret)
{
  $stat = $ret['status'];

  if($stat == "error")
    echo "Error: " . $ret['error'];
  elseif($stat == "already")
    echo "You are already logged in!";
  elseif($stat == "nouser")
    echo "No user found. User creation is not implemented yet";
  elseif($stat == "ok")
    echo "You are now logged in!";
  else
    {
      echo "Something went wrong. Details:<br>";
      print_r($ret);
    }
}
?>