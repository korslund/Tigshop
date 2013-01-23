<?php
require_once 'db_setup.php';

define("TBL_APIKEYS", "tigshop_apikeys");

/* Set up the database table. Not called during normal operation.
 */
function db_createAPITable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_APIKEYS);

  db_run("CREATE TABLE " . TBL_APIKEYS .
         "(code varchar(12) primary key,
           expire_date datetime,
           userid int unsigned,
           descr text,
           index userid_index(userid))");
}

/* Insert an API key entry. Newly inserted keys have an expire_date
   set to NOW(), which means they will always be replaced immediately
   on first use.
 */
function db_API_addKey($key, $desc, $userid)
{
  $key = db_esc($key);
  $desc = db_esc($desc);
  $userid = db_esc($userid);

  db_run("INSERT INTO ".TBL_APIKEYS.
         "(code,expire_date,userid,descr) ".
         "VALUES('$key', NOW(), '$userid', '$desc')");

  return $id;
}

/* Remove an entry
 */
function db_API_killKey($key)
{
  $key = db_esc($key);
  db_run("DELETE FROM ".TBL_APIKEYS." WHERE code='$key'");
}

/* Change the description of an entry
 */
function db_API_nameKey($key, $newname)
{
  $key = db_esc($key);
  $newname = db_esc($newname);
  db_run("UPDATE ".TBL_APIKEYS." SET descr='$newname' WHERE code='$key'");  
}

/* List all the keys belonging to a user
 */
function db_API_listKeys($userid)
{
  $userid = db_esc($userid);
  $out = db_run("SELECT code,descr FROM ".TBL_APIKEYS." WHERE userid='$userid'");
  $ret = array();
  while($row = $out->fetch_assoc())
    {
      array_push($ret, array("key" => $row['code'],
                             "desc" => $row['descr']));
    }
  return $ret;
}

/* Check an API key. If valid, returns an array with relevant
   information. If not, returns null.

   If the key has expired, the function may replace it in the database
   with a newly generated one. The new key is included in the return
   array.
 */
function db_API_checkKey($key)
{
  $key = db_esc($key);
  $res = db_run_array("SELECT userid,expire_date,descr FROM ".
                      TBL_APIKEYS." WHERE code='$key'");

  if(!$res) return null;

  // Set up the return value
  $retval = array();
  $retval['userid'] = $res['userid'];
  $retval['desc'] = $res['descr'];

  // Get the expiry date from MySQLs datetime format
  $expdate = strtotime($res['expire_date']);

  // If the code has expired, then renew it
  if(time() > $expdate)
    {
      require_once 'passwords.php';
      $newkey = generateRandStr(12);

      db_run("UPDATE ".TBL_APIKEYS." SET code='$newkey',expire_date=ADDDATE(NOW(),1) WHERE code='$key'");
      $retval['newkey'] = $newkey;
    }

  return $retval;
}
?>