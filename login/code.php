<?php
require '../modules/login_common.php';
require '../modules/frontend_login.php';
require_once '../modules/frontend_urls.php';
require '../modules/db_code.php';
require '../modules/nonce.php';

/* This file may be called with one of the following:

   GET: email=email pass=password
   GET: code=one-time-code

   The password part isn't implemented, we might move that to a
   separate file for clarity.
 */

if(isset($_GET['redir']))
  redirect_set_session($_GET['redir']);

if(isset($_GET['email']) && isset($_GET['pass']))
  {
    tg_requireNonceGET("login_nonce");
    echo "Password login not implemented yet!";
    exit;
  }

if(!isset($_GET['code']))
  die("Missing code!");

// Look up the code
$code = $_GET['code'];
$info = db_getCode($code);
$type = $info['type'];

// Check the code type
$ret = '';
if($type == 'login_auth')
  {
    $auth = $info['data'];

    // Log the user in
    $ret = login_auth($auth, true);

    // Delete the code entry
    db_removeCode($code);
  }
else
  die("This code has expired or is no longer valid. Please request a new code.");

frontend_handle_login($ret);
?>