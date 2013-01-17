<?php
require_once 'db_setup.php';

define("TBL_APIKEYS", "tigshop_apikeys");

/* Set up the database table. Not called during normal operation.
 */
function db_createAPITable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_APIKEYS);

  db_run("CREATE TABLE " . TBL_APIKEYS .
         "(code varchar(8) primary key,
           expire_date datetime,
           userid int unsigned,
           descr text,
           index userid_index(userid))");
}

/* Insert an API key entry
 */
function db_API_addKey($key, $desc, $userid)
{
  $key = db_esc($key);
  $desc = db_esc($desc);
  $userid = db_esc($userid);

  db_run("INSERT INTO ".TBL_APIKEYS.
         "(code,expire_date,userid,descr) ".
         "VALUES('$key', ADDDATE(NOW(), 7), '$userid', '$desc')");

  return $id;
}

/* Remove an entry
 */
function db_API_killKey($key, $userid)
{
  $key = db_esc($key);
  $userid = db_esc($userid);
  db_run("DELETE FROM ".TBL_APIKEYS." WHERE (code='$key' AND userid='$userid')");
}

/* Get a code entry. Will auto-delete it if it is too old. Returns an
   array with appropriate elements.

   Possible return types:

   - missing
   - expired
   - login_id
   - login_auth
 */
function db_getCode($code)
{
  $code = db_esc($code);
  $res = db_run_array("SELECT userid,expire_date,code_type,extra_data FROM ".
                      TBL_APIKEYS." WHERE code='$code'");

  if(!$res)
    return array("type" => "missing");

  // Get the expiry date from MySQLs datetime format
  $expdate = strtotime($res['expire_date']);

  // If the code has expired, then remove it and don't process it
  if(time() > $expdate)
    {
      db_removeCode($code);
      return array("type" => "expired");
    }

  $retval = array();
  $retval['userid'] = $res['userid'];
  $retval['data'] = $res['extra_data'];

  // Look up type
  $tp = $res['code_type'];
  if($tp == '1') $tp = 'login_id';
  elseif($tp == '2') $tp = 'login_auth';
  else die("Invalid DB entry");
  $retval['type'] = $tp;

  return $retval;
}
?>