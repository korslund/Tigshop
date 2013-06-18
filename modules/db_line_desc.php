<?php
require_once 'db_setup.php';

define("TBL_LINE_DESC", "tigshop_line_desc");

function db_createLineDescTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_LINE_DESC);

  db_run("CREATE TABLE " . TBL_LINE_DESC .
         "(lineid INT UNSIGNED AUTO_INCREMENT,
           creation_date datetime,
           ownerid int unsigned,
           title text,
           descr text,
           status tinyint(1) unsigned,
           primary key(lineid),
           index owner_index(ownerid))");
}

function db_createLine($owner, $title, $descr, $status)
{
  $owner = db_esc($owner);
  $title = db_esc($title);
  $descr = db_esc($descr);
  $status = db_esc($status);

  db_run("INSERT INTO ".TBL_LINE_DESC.
         "(creation_date, ownerid, title, descr, status) ".
         "VALUES(NOW(), '$owner', '$title', '$descr', '$status')");

  return db_getId();
}

function db_updateLine($lineid, $owner, $title, $descr, $status)
{
  $lineid = db_esc($lineid);
  $owner = db_esc($owner);
  $title = db_esc($title);
  $descr = db_esc($descr);
  $status = db_esc($status);

  db_run("UPDATE ".TBL_LINE_DESC.
         " SET ownerid='$owner', title='$title', descr='$descr', status='$status'".
         " WHERE lineid='$lineid'");
}

/* Get line info. Returns an associative array, or 'false' if no such
   line was found.
 */
function db_getLine($lineid)
{
  $lineid = db_esc($lineid);
  return db_run_array("SELECT * FROM ".TBL_LINE_DESC." WHERE lineid='$lineid'");
}

function db_listLines($byUser = "")
{
  $byUser = db_esc($byUser);

  $q = "SELECT lineid FROM ".TBL_LINE_DESC;
  if($byUser != "")
    $q .= " WHERE ownerid='$byUser'";

  $out = db_run($q);
  $ret = array();
  while($row = $out->fetch_assoc())
    array_push($ret, $row['lineid']);
  return $ret;
}
?>