<?php
require_once 'db_setup.php';

define("TBL_CODES", "tigshop_codes");

/* Set up the database table. Not called during normal operation.
 */
function db_createCodeTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_CODES);

  db_run("CREATE TABLE " . TBL_CODES .
         "(code varchar(8) primary key,
           expire_date datetime,
           userid int unsigned,
           code_type tinyint(1) unsigned,
           extra_data text)");
}

/* Create a new random code with the given parameters. The code is
   returned.
 */
function db_addCodeRaw($userid, $exp_days, $type, $data)
{
  $userid = db_esc($userid);
  $exp_days = db_esc($exp_days);
  $type = db_esc($type);
  $data = db_esc($data);

  $id = substr(generateRandomID(),0,8);

  db_run("INSERT INTO ".TBL_CODES.
         "(code,expire_date,userid,code_type,extra_data) ".
         "VALUES('$id', ADDDATE(NOW(), $exp_days), '$userid', '$type', '$data')");

  return $id;
}

/* Create an email login key that will log you in or create a user
   based on an auth string
 */
function db_addLoginCode($auth, $expire_days = 1)
{ return db_addCodeRaw(0, $expire_days, 2, $auth); }

// Kill a code table entry
function db_removeCode($code)
{
  $code = db_esc($code);
  db_run("DELETE FROM ".TBL_CODES." WHERE code='$code'");
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
                      TBL_CODES." WHERE code='$code'");

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