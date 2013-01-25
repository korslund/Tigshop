<?php

require_once 'db_code.php';

$code = $_GET['login_code'];
$info = db_getCode($code);

// Check what kind of code we've got
$type = $info['type'];
if($type == 'login_auth')
  {
    require_once 'handle_login_common.php';
    $ret = login_auth($info['data'], true);

    // Delete the code entry
    db_removeCode($code);

    // Compute the return URL
    require 'urltools.php';
    $newURL = url_remove_get(get_this_url(), "login_code");

    // Handle the return value
    handle_login_ret($ret, $newURL);
  }
else
  die("This code has expired or is no longer valid. Please request a new code.");
?>