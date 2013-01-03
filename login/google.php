<?php
require '../modules/login_common.php';
require '../modules/frontend_login.php';

$ret = login_google(DOMAIN_NAME);

if($ret['valid'])
  {
    $ret = login_email($ret['email']);
    frontend_handle_login($ret);
    exit;
  }

// The user was not logged in. We'll add better error handling later.
echo "Could not sign in, status=" . $ret['status'];
?>