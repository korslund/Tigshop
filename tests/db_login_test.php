<?php
require '../modules/db_login.php';

function chk($pass)
{
  echo 'Checking login: ';
  if(checkLogin("user", $pass)) echo "PASSED<br>";
  else echo "FAILED<br>";
}

chk("whatever");
echo 'Logging in<br>';
$pass = addLogin("user");
chk($pass);
echo 'Logging out<br>';
removeLogin("user");
chk($pass);
echo "pass=$pass";
?>
