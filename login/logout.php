<?php
require '../modules/auto_login.php';
require '../modules/frontend_urls.php';

if($g_loggedIn)
  {
    doLogout($g_userid);
    redirect_home();
  }
else
  echo "You are not logged in!";
?>