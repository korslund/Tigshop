<?php

/* Accepted signals:

   act=signout key=authkey:

      Sign the user out by deleting the given auth key from the
      database.
 */

$action = @$_GET['act'];
$key = @$_GET['key'];

if($action == "signout")
  {
    // TODO: check for a valid key (create some sanitation checks,
    // keys are easy to validate)
    if($key == "") exit;

    // Kill the key from the database
    require '../modules/db_apikey.php';
    db_API_killKey($key);
  }
?>