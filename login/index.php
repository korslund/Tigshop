<?php
require_once '../modules/auto_login.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Sign In - tigshop.com</title>
<!--link rel="stylesheet" type="text/css" href="/css/main.css"-->
<!--link rel="shortcut icon" href="/tiggit.ico"-->
</head>
<body>
<?php
if($g_loggedIn)
  {
?>
<p>You are already logged in! You may add other logins to your account (not implemented yet)</p>
<?php
  }
else
  {
?>
<p>Sign in using one of the following options:</p>
<form action="google.php" method="get">
<button>Google</button></form>
<?php
  }
?>
</body>
</html>
