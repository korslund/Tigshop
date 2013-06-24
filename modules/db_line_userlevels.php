<?php
require_once 'db_setup.php';

define("TBL_LINE_USERLEVEL", "tigshop_line_userlevel");

function db_createLineUserlevelTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_LINE_USERLEVEL);

  db_run("CREATE TABLE " . TBL_LINE_USERLEVEL .
         "(lineid int unsigned,
           userid int unsigned,
           level decimal(8,2),
           index user_index(userid),
           primary key(lineid,userid))");
}

function db_setUserLevel($userid, $lineid, $level)
{
  $lineid = db_esc($lineid);
  $userid = db_esc($userid);
  $level = db_esc($level);

  db_run("REPLACE INTO ".TBL_LINE_USERLEVEL.
         "(lineid, userid, level) ".
         "VALUES('$lineid', '$userid', '$level')");
}

function db_getUserLevel($userid, $lineid)
{
  $userid = db_esc($userid);
  $lineid = db_esc($lineid);
  $res = db_run_array("SELECT level FROM ".TBL_LINE_USERLEVEL." WHERE userid='$userid' AND lineid='$lineid' LIMIT 1");

  if($res) return $res['level'];
  else return 0;
}

function db_listUserLevels($byUser = "")
{
  $byUser = db_esc($byUser);

  $q = "SELECT * FROM ".TBL_LINE_USERLEVEL;
  if($byUser != "")
    $q .= " WHERE userid='$byUser'";

  return db_run_multi($q);
}
?>