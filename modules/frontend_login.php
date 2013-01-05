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
  $auth = $ret['auth'];

  /* TODO: All of these cases will be expanded with addition
     functionality and error handling later.

     For example, we might want to redirect all users to a given page
     (approve these new settings, or whatever) before redirecting them
     to their real destination. We've stipulated where to put such a
     call below under the name redirect_user_landing(). This function
     would default to just calling redirect_session() if no special
     page is necessary.
   */

  if($stat == "ok")
    {
      $_SESSION['tigshop_cur_auth'] = $auth;
      redirect_session();
    }
  elseif($stat == "already")
    {
      /* 'new_auth' is set if the user tried reauthenticating in while
         already logged in. This may or may not provide us a new
         authentication ID to add to the account - remember it so we
         may warn the user about it.
      */
      $_SESSION['tigshop_new_auth'] = $auth;
      //redirect_user_landing();
      redirect_session();
    }
  elseif($stat == "nouser")
    {
      // No user was found matching this ID. So create one.
      require_once 'login_common.php';
      $id = createUserFromAuth($auth);

      // Log in as the new user
      $ret2 = login_auth($auth, $ret['keep']);
      if($ret2['status'] == "ok" && $ret2['userid'] == $id)
        {
          /* 'new_user' is set if a new user was created. This can be
             used by other pages to inform the new users about
             important stuff.
          */
          $_SESSION['tigshop_new_user'] = true;
          $_SESSION['tigshop_cur_auth'] = $auth;
          //redirect_user_landing();
          redirect_session();
        }

      echo "Error: failed to log in as new user. Details:<br>id=$id<br>";
      print_r($ret2);
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