<?php
require '../modules/api_response.php';

$v = '0';
if(isset($_GET['v']))
  $v = $_GET['v'];

if($v == "1") $res = api_pack_userinfo(123, "abcd", "New Key Man", "Home");
elseif($v == "2") $res = api_pack(22, "", "String value");
elseif($v == "3") $res = api_pack(11, "", array("foo", "soap", "fish"));
elseif($v == "4") $res = api_pack(1, "KEY", "http://some/link/here");
elseif($v == "5") $res = api_error_key();
elseif($v == "6") $res = api_error_access("You do not have access to download this game");
else $res = api_pack_userinfo("321", "", "John Deer", "Laptop");

api_json_output($res);
?>