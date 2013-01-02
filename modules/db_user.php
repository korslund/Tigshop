<?php
require_once 'db_setup.php';

define("TBL_USERS", "tigshop_users");

/* Set up the database table. Not called during normal operation.
 */
function db_createUserTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_USERS);

  db_run("CREATE TABLE " . TBL_USERS .
         "(userid INT UNSIGNED AUTO_INCREMENT,
           nickname varchar(128),
           creation_date datetime,
           primary key(userid))");
}

/* Create a new user. Returns the userid.
 */
function db_addUser($nickname = "")
{
  $nickname = db_esc($nickname);

  db_run("INSERT INTO ".TBL_USERS.
         "(nickname,creation_date) VALUES('$nickname', NOW())");

  return db_getId();
}

/* Get user info. Returns an associative array, or 'false' if no such
   user was found.
 */
function db_getUser($userid)
{
  $userid = db_esc($userid);
  $res = db_run_array("SELECT nickname,creation_date FROM ".TBL_USERS." WHERE userid='$userid'");

  if($res)
    $res['valid'] = true;

  return $res;
}

/* Kill a user account. TODO: Does not kill the actual user.
 */
function db_killUser($userid)
{
  $userid = db_esc($userid);
  db_run("DELETE FROM ".TBL_USERS." WHERE userid='$userid'");
}
?>