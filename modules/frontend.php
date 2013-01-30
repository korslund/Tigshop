<?php
require 'handle_login.php';
require 'frontend_header.php';
require 'frontend_urls.php';

function display_login_options()
{
  $nonce = tg_getFormNonce("login_nonce");
  $page = $_SERVER['PHP_SELF'];
  $query = $_SERVER['QUERY_STRING'];
  if($query != "") $page .= "?".$query;
  $page = htmlentities($page);

  function form_start($type, $nonce, $page)
  {
    echo '<form action="'.$page.'" method="post">';
    echo '<input type="hidden" name="login_type" value="'.$type.'"/>';
    echo $nonce;
  }

?>
<hr/>
<p>Sign in / create account using:</p>
<?php echo form_start("google", $nonce, $page);?>
<input value="Google" type="submit"/></form>
<hr/>
<?php echo form_start("email", $nonce, $page);?>
Email: <input name="email" type="text"/>
<input value="Send login link" type="submit"/></form>
<?php
  /*
<hr/>
<p>Email/password combo. Set a password after creating an account.</p>
<form action="code.php<?php echo $redir;?>" method="get">
<?php echo $nonce;?>
Email: <input name="email" type="text"/><br>
Password: <input name="pass" type="password"/><br>
<input value="Log in" type="submit"/></form>
<p>Tip: create a password on the homepage after logging in</p>
<?php
     */
}

function html_user_header($title, $reqLogin=false)
{
  global $g_loggedIn, $g_userid, $g_user_info;

  html_header($title);

  echo '<a href="'.url_home().'">TigShop</a>';

  if($g_loggedIn)
    {
      $nick = $g_user_info['nickname'];
      if($nick == "") $name = $g_userid;
      else $name = "$nick($g_userid)";

      echo ' | Logged in as <a href="'.url_userhome().'">'.$name.'</a> | ';

      require_once 'urltools.php';
      $logoutURL = get_this_url();
      $logoutURL = url_add_get($logoutURL, "logout", $g_userid);

      /* If this page requires being logged in, then tell the logout
         subsystem to redirect home rather than back to this page.
       */
      if($reqLogin) $logoutURL = url_add_get($logoutURL, "gohome");
      echo '<a href="'.htmlentities($logoutURL).'">Log out</a>';

      if($g_user_info['nickname'] == "")
        echo '<p>To set your nickname, go to <a href="'.url_userhome().'">account settings</a></p>';
      echo '<hr/>';

      /* If an 'asuser' GET parameter was specified (usually from API
         requests), that means the calling client expects us to be
         logged in as a specific user.
       */
      if(isset($_GET['asuser']))
        {
          $asUser = htmlentities($_GET['asuser']);

          if($asUser != $g_userid)
            {
?>
<p>You are not signed in as the right user to perform this action!</p>
<p>Expected to be logged in as user <?php echo $asUser;?>, but you are currently logged in as user <?php echo $g_userid;?>.</p>
<p>Possible causes:</p>
<ul>
<li>You are using multiple accounts on this computer.
<br><br><b>Solution:</b>
Log out and log back in as the right user.<br><br></li>
<li>You have accidentally created several user accounts by logging in with different emails.
<br><br><b>Solution:</b>
Send a merge request to user <?php echo $asUser;?>. They will get a link to their primary email account to accept the merge request. NOT IMPLEMENTED YET.</li>
</ul>
<?php
              echo makeLink(url_remove_get(get_this_url(),"asuser"), "Continue viewing the page anyway");
              html_exit();
            }
        }
    }
  else
    {
      if($reqLogin)
        {
          echo '<p>This page requires that you are logged in!</p>';
          display_login_options();
          html_exit();
        }

      // TODO: Display hidden per default using JS
      echo '<p>Sign in or create account:</p>';
      display_login_options();
      echo '<hr/>';
    }
}
?>