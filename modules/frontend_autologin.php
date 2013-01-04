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