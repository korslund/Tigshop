<?php
require 'auto_login.php';

function html_user_bar()
{
  global $g_loggedIn, $g_userid, $g_user_info;

  require_once 'frontend_urls.php';

  if($g_loggedIn)
    {
      $nick = $g_user_info['nickname'];
      if($nick == "") $name = $g_userid;
      else $name = "$nick($g_userid)";

      echo 'Logged in as <a href="'.url_userhome().'">'.$name.'</a> | ';
      echo '<a href="'.url_logout().'">Log out</a>';

      $last_auth = $_SESSION['last_auth'];
      if(isset($_SESSION['new_auth']))
        {
          $new_auth = $_SESSION['new_auth'];
          unset($_SESSION['new_auth']);

          if($new_auth != $last_auth)
            {
              // Check if new_auth belongs to this user
              if(db_getUserFromAuth($new_auth) != $g_userid)
                {
                  echo "<p>Tried to log in as $new_auth but you are already logged as $last_auth! ";
                  echo "Go to preferences (not implemented yet) to manage account settings.</p>";
                  $_SESSION['add_auth'] = $new_auth;
                }
            }
        }

      if(isset($_SESSION['new_user']) && $_SESSION['new_user'])
        {
          unset($_SESSION['new_user']);
          echo "<p>New user created for ".$last_auth."!</p>";
        }
      if($g_user_info['nickname'] == "")
        echo '<p>To set your nickname, go to <a href="'.url_userhome().'">account settings</a></p>';
    }
  else
    {
?>
<p>Sign in using one of the following options:</p>
<form action="<?php echo url_login_google(); ?>" method="get">
<button>Google</button></form>
<?php
    }
  echo '<hr/>';
}

function require_login($redir="")
{
  global $g_loggedIn;
  if($g_loggedIn) return;

  // User is NOT logged in. Redirect them to a login page.
  require_once 'frontend_urls.php';
  redirect_login($redir);
}
?>