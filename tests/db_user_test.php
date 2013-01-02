<?php
require '../modules/db_user.php';

function chk($id)
{
  echo "User $id: ";
  $info = db_getUser($id);

  if($info)
    {
      echo "Found. User is ";
      if(!$info['valid']) echo "NOT ";
      echo "valid. ";
      $nick = $info['nickname'];
      if($nick != "") echo "Nickname: $nick ";
      else echo "No nickname. ";
    }
  else
    echo "NOT found!";

  echo '<br>';
}

chk(1);
$id = db_addUser("bjarne");
chk($id);
db_killUser($id);
chk($id);
?>