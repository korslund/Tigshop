<?php
require '../modules/db_login.php';

function chk($pass)
{
  echo 'Checking login: ';
  if(db_checkLogin("user", $pass)) echo "PASSED<br>";
  else echo "FAILED<br>";
}

chk("whatever");
echo 'Logging in<br>';
$pass = db_addLogin("user");
chk($pass);
echo 'Logging out<br>';
db_removeLogin("user");
chk($pass);
echo "pass=$pass";
?>
