<?php

require '../modules/login_functions.php';

$ret = login_google("http://nkorslund.com");

echo "Type: " . $ret['type'];
echo "<br>Valid: " . $ret['valid'];
echo "<br>Status: " . $ret['status'];
echo "<br>Openid: " . $ret['openid'];
echo "<br>Provider: " . $ret['provider'];
echo "<br>Email: " . $ret['email'];
?>