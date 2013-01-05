<?php
require '../modules/login_common.php';
require '../modules/frontend_login.php';
require_once '../modules/frontend_urls.php';

// Check if the caller wanted us to redirect somewhere special
if(isset($_GET['redir']))
  redirect_set_session($_GET['redir']);

if(isset($_GET['email']))
  {
    // TODO: We just accept the email with no confirmation for
    // now. This obviously isn't production code.
    $ret = login_email($_GET['email'], true);
    frontend_handle_login($ret);
    exit;
  }
?>
<form action="#" method="get">
<input name="email" type="text"/>
<input value="Sign in" type="submit"/>
</form>