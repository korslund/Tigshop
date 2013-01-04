<?php
require '../modules/login_common.php';
require '../modules/frontend_login.php';
require_once '../modules/frontend_urls.php';

// Check if the caller wanted us to redirect somewhere special
if(isset($_GET['redir']))
  redirect_set_session($_GET['redir']);

$ret = login_google(DOMAIN_NAME);

if($ret['valid'])
  {
    $ret = login_email($ret['email'], true);
    frontend_handle_login($ret);
    exit;
  }

// The user was not logged in. We'll add better error handling later.
echo "Could not sign in, status=" . $ret['status'];
?>