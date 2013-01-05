<?php
require 'login_db_session.php';

/* If false, it means the user existed but is not allowed to log
   in. The page can explore g_user_info for more information (not
   implemented yet.)
 */
$g_user_valid = true;
$g_user_info = array();

if($g_loggedIn)
  {
    require_once 'db_user.php';

    // Disable logged-in status, reenable it below.
    $g_loggedIn = false;

    // Check if the login account is valid
    $info = db_getUser($g_userid);
    $g_user_info = $info;

    if($info)
      if($info['valid'])
        $g_loggedIn = true;
      else
        $g_user_valid = false;
  }
?>