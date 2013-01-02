<?php
require '../modules/db_auth.php';

function chk($auth)
{
  echo "Auth:$auth => ";
  $id = db_getUserFromAuth($auth);
  if($id == "") echo "Not found.";
  else echo "User:$id";
  echo "<br>";
}

function lst($id)
{
  echo "ID:$id: ";
  $arr = db_getAuthList($id);
  foreach($arr as $value)
    {
      echo $value . " ";
    }
  echo '<br>';
}

chk("a@b.com");
lst("1");
db_addAuthEntry("a@b.com", "1");
db_addAuthEntry("T:twitface", "1");
db_addAuthEntry("k@g.com", "2");

chk("a@b.com");
chk("T:twitface");
chk("k@g.com");
lst("1");
lst("2");

db_removeAuthEntry("a@b.com");
db_removeAuthEntry("T:twitface");
db_removeAuthEntry("k@g.com");

chk("k@g.com");
lst("2");
?>