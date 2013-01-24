<?php

/* TODO: refactor all the old login code as well, after you've
   finished working on this.
 */
require_once 'login_common.php';

$ret = login_google(DOMAIN_NAME);
if($ret['valid'])
  {
    $ret = login_email($ret['email'], true);

    /* TODO: Do the equivalent of frontehnd_handle_login() here.  The
       most important part to create the user if necessary. We should
       also redirect back to this page once we're logged in,
       however. Hmm this is getting messy.
    */
    $stat = $ret['status'];
    if($stat == 'ok')
      {
        // If everything was ok, then return to the original URL
        header("Location: ".$_GET['openid_return_to']);
      }
    die("login_email() status: $stat");
  }
die("login_google() status: ".$ret['status']);
?>