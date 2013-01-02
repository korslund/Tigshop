<?php
require_once '../modules/login_db_session.php';

if(isset($_GET['logout']))
  {
    doLogout("myuser");
    header('Location: login_db_session_test.php');
    exit;
  }
elseif(isset($_GET['login']))
  {
    doLogin("myuser", true);
    header('Location: login_db_session_test.php');
    exit;
  }

if($g_loggedIn)
  {
    echo "Logged in as $g_userid<br>";
?>
<form action="?logout" method="post">
<button>Logout</button></form>
<?php
  }
else
  {
    echo 'Not logged in';
?>
<form action="?login" method="post">
<button>Login</button></form>
<?php
   }
?>
