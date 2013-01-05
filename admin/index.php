<?php
require '../modules/admin_page.php';
require_once '../modules/db_user.php';
require_once '../modules/db_auth.php';
require_once '../modules/auth_code.php';
require_once '../modules/frontend_urls.php';

/* These actions are powerful. They should of course be nonced,
   require confirmation and have other safety checks.
 */
if(isset($_GET['action']))
  {
    $act = $_GET['action'];
    $val = $_GET['value'];

    if($act == "delete")
      {
        db_killUser($val);
        db_killAuthUser($val);
        db_removeLogin($val);
      }
    // This didn't work .. figure out why
    /*
    elseif($act == "become")
      {
        if($val != $g_userid)
          doLogin($userid, true);

        redirect_userhome();
      }
    */
  }

html_header("The Indie Game Shop");
html_user_bar();

echo '<p>If you see this, you are viewing an admin page!</p>';

$users = db_listUsers();

echo 'Users:<br>';
foreach($users as $uid)
  {
    $auths = db_getAuthList($uid);

    echo "<b>User $uid:</b> "/*<a href=\"index.php?action=become&value=$uid\">become</a>*/."<a href=\"index.php?action=delete&value=$uid\">delete</a><br>";
    foreach($auths as $auth)
      echo disp_auth($auth).'<br>';
    echo '<br>';
  }

html_footer();
?>