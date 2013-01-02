<?php
require '../modules/db_login.php';

function chk()
{
  echo 'Checking login: ';
  if(checkLogin("user", "pass")) echo "PASSED<br>";
  else echo "FAILED<br>";
}

chk();
echo 'Logging in<br>';
addLogin("user", "pass");
chk();
echo 'Logging out<br>';
removeLogin("user");
chk();
?>
