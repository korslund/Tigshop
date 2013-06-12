<?php
require_once 'handle_login.php';

// Fix this later
if(!$g_loggedIn || $g_userid != '7')
  die("Oops, you cannot view this page");

// TODO: Add more admin-specific stuff, including logging. We
// have example code for this elsewhere.
?>