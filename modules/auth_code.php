<?php
function auth_decode($auth)
{
  if(strlen($auth) < 3 || $auth[1] != ":")
    die("Invalid auth string '$auth'");

  $res = array();
  $res['type'] = $auth[0];
  $res['value'] = substr($auth, 2);
  return $res;
}

function auth_encode_twitter($id) { return "T:".$id; }
function auth_encode_email($id)   { return "E:".$id; }
?>