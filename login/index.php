<?php
require_once '../modules/auto_login.php';
require_once '../modules/frontend_header.php';
//require '../modules/frontend_autologin.php';

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
?>
<p>Sign in using one of the following options:</p>
<form action="google.php<?php echo $redir; ?>" method="get">
<button>Google</button></form>
<a href="email.php">Login with email</a>
<?php
  }
html_footer();
?>
