<?php
require '../modules/session_login.php';

$val = get_login_info();

if(isset($_GET['logout']))
  {
    clear_login_info();
    header('Location: session_test.php');
    exit;
  }
elseif(isset($_GET['login']))
  {
    set_login_info("abcd", "1234", true);
    header('Location: session_test.php');
    exit;
  }

if($val['logged_in'])
  {
    echo 'Logged in:';
    echo '<br>Type: ' . $val['source'];
    echo '<br>UserID: ' . $val['userid'];
    echo '<br>Key: ' . $val['key'];
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
