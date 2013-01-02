<?php
require_once 'db_setup.php';

/* The auth database holds individual authentication identities
   (emails, twitter ids, etc) associated with user accounts. There may
   be several IDs to any one account, but the same ID may not connect
   to multiple accounts.
 */

define("TBL_AUTH", "tigshop_auth");

/* Set up the database table. Not called during normal operation.
 */
function db_createAuthTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_AUTH);

  db_run("CREATE TABLE " . TBL_AUTH .
         "(auth_id varchar(128) primary key,
           userid int,
           index userid_index (userid))");
}

/* Adds a new auth<>user association. The auth may NOT already exist.
 */
function db_addAuthEntry($auth_id, $userid)
{
  $auth_id = db_esc($auth_id);
  $userid = db_esc($userid);

  db_run("INSERT INTO ".TBL_AUTH.
         "(auth_id,userid) VALUES('$auth_id', '$userid')");
}

/* Remove an auth entry
 */
function db_removeAuthEntry($auth_id)
{
  $auth_id = db_esc($auth_id);
  db_run("DELETE FROM ".TBL_AUTH." WHERE auth_id='$auth_id'");
}

/* Get userid associated with a given auth. Returns "" if none was
   found.
 */
function db_getUserFromAuth($auth_id)
{
  $auth_id = db_esc($auth_id);
  $res = db_run_array("SELECT userid FROM ".TBL_AUTH." WHERE auth_id='$auth_id'");
  if($res) return $res['userid'];
  return "";
}

/* Get list of all auth ids associated with a given userid.
 */
function db_getAuthList($userid)
{
  $userid = db_esc($userid);
  $out = db_run("SELECT auth_id FROM ".TBL_AUTH." WHERE userid='$userid'");

  $ret = array();
  while($row = $out->fetch_assoc())
    array_push($ret, $row['auth_id']);
  return $ret;
}
?>