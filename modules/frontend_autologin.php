<?php
require 'auto_login.php';

$g_cur_auth = htmlentities($_SESSION['tigshop_cur_auth']);

function html_user_bar()
{
  global $g_loggedIn, $g_userid, $g_user_info, $g_cur_auth;

  require_once 'frontend_urls.php';

  echo '<a href="'.url_home().'">TigShop</a> | ';

  if($g_loggedIn)
    {
      $nick = $g_user_info['nickname'];
      if($nick == "") $name = $g_userid;
      else $name = "$nick($g_userid)";

      echo 'Logged in as <a href="'.url_userhome().'">'.$name.'</a> | ';
      echo '<a href="'.url_logout().'">Log out</a>';

      if(isset($_SESSION['tigshop_new_auth']))
        {
          $new_auth = $_SESSION['tigshop_new_auth'];
          unset($_SESSION['tigshop_new_auth']);

          if($new_auth != $g_cur_auth)
            {
              // Check if new_auth belongs to this user
              if(db_getUserFromAuth($new_auth) != $g_userid)
                {
                  echo "<p>Tried to log in as $new_auth but you are already logged as ".disp_auth($g_cur_auth)."! ";
                  echo "Go to preferences (not implemented yet) to manage account settings.</p>";
                  $_SESSION['tigshop_add_auth'] = $new_auth;
                }
            }
        }

      if(isset($_SESSION['tigshop_new_user']) && $_SESSION['tigshop_new_user'])
        {
          unset($_SESSION['tigshop_new_user']);
          echo "<p>New user created for ".disp_auth($g_cur_auth)."!</p>";
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