<?php
require '../modules/auth_code.php';

function chk($str)
{
  echo "$str => ";
  print_r(auth_decode($str));
  echo '<br>';
}

chk(auth_encode_twitter("twitface"));
chk(auth_encode_email("jack@boots.nao"));
chk("doesnt_work");

?>