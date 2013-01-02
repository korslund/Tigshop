<?php
require_once 'db_setup.php';
require_once 'passwords.php';

define("TBL_LOGINS", "tigshop_logins");

/* Set up the database table. Not called during normal operation.
 */
function db_createLoginTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_LOGINS);

  db_run("CREATE TABLE " . TBL_LOGINS .
         "(userid varchar(32) primary key,
           passkey varchar(192),
           login_date datetime)");
}

/* Add a new login entry. Will replace any existing entry for the same
   user - you can only be logged in from one place at once.

   Returns a randomly generated key, which must be passed to future
   calls to db_checkLogin().
 */
function db_addLogin($userid)
{
  $userid = db_esc($userid);

  $key = generateRandomID();
  $pass = createHash($userid . $key, SITE_LOGIN_KEY);

  db_run("REPLACE INTO ".TBL_LOGINS.
         "(userid,passkey,login_date) VALUES('$userid', '$pass', NOW())");

  return $key;
}

/* Check login entry. Returns true on match, false otherwise.

   TODO: Might add an optional expiry time later.
 */
function db_checkLogin($userid, $key)
{
  $userid = db_esc($userid);
  $key = db_esc($key);

  $row = db_run_array("SELECT userid,passkey FROM ".TBL_LOGINS." WHERE userid='$userid'");

  $pass = $row['passkey'];

  // Check that the passkey hashes correctly
  return $key != "" && checkPassword($pass, $userid . $key, SITE_LOGIN_KEY);
}

/* Remove login entry for the given userid.
 */
function db_removeLogin($userid)
{
  $userid = db_esc($userid);
  db_run("DELETE FROM ".TBL_LOGINS." WHERE userid='$userid'");
}
?>