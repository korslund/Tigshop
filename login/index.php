<?php
require_once '../modules/auto_login.php';
require_once '../modules/frontend_header.php';
//require '../modules/frontend_autologin.php';
require '../modules/nonce.php';

html_header("Sign In");

if($g_loggedIn)
  {
    echo '<p>You are already logged in! You may add other logins to your account (not implemented yet)</p>';
  }
else
  {
    $redir = "";
    if(isset($_GET['redir']))
      {
        echo '<p>You have to log in to view this page</p>';
        $redir = "?redir=".htmlentities(urlencode($_GET['redir']));
      }

    $nonce = tg_getFormNonce("login_nonce");
?>
<p>Sign in with an external service:</p>
<form action="google.php<?php echo $redir;?>" method="get">
<button>Google</button></form>
<hr/>
<p>Send a one-use login link by email. Creates a new account if one doesn&#39;t exist.</p>
<form action="send_email.php<?php echo $redir?>" method="post">
<?php echo $nonce;?>
Email: <input name="email" type="text"/>
<input value="Send login link" type="submit"/></form>
<hr/>
<?php
/*
<p>Log in using email/password combo. Requires an existing account with a password set up.</p>
<form action="code.php<?php echo $redir;?>" method="get">
<?php echo $nonce;?>
Email: <input name="email" type="text"/><br>
Password: <input name="pass" type="password"/><br>
<input value="Log in" type="submit"/></form>
<p>Tip: create a password on the homepage after logging in</p>
<?php
     */
  }
html_footer();
?>
