<?php
require_once 'db_setup.php';

define("TBL_OWNERSHIP", "tigshop_ownership");

/* Set up the database table. Not called during normal operation.
 */
function db_createOwnerTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_OWNERSHIP);

  db_run("CREATE TABLE " . TBL_OWNERSHIP .
         "(ownerid int unsigned,
           prodid varchar(32),
           purchase_date datetime,
           index owner_index(ownerid),
           index prod_index(prodid))");
}

function db_addPurchase($ownerid, $prodid)
{
  $ownerid = db_esc($ownerid);
  $prodid = db_esc($prodid);

  db_run("INSERT INTO ".TBL_OWNERSHIP.
         "(ownerid,prodid,purchase_date)".
         " VALUES('$ownerid', '$prodid', NOW())");
}

function db_isOwner($userid, $prodid)
{
  $userid = db_esc($userid);
  $prodid = db_esc($prodid);

  $count = db_run_count("SELECT 1 FROM ".TBL_OWNERSHIP.
                        " WHERE ownerid='$userid' AND prodid='$prodid' LIMIT 1");
  return $count != 0;
}

function db_listOwners($prodid)
{
  $prodid = db_esc($prodid);
  return db_run_multi("SELECT * FROM ".TBL_OWNERSHIP.
                      " WHERE prodid='$prodid'");
}

function db_listOwnerProducts($userid)
{
  $userid = db_esc($userid);
  return db_run_multi("SELECT * FROM ".TBL_OWNERSHIP.
                      " WHERE ownerid='$userid'");
}

function db_listOwnerProductIDs($userid)
{
  $userid = db_esc($userid);
  $out = db_run("SELECT prodid FROM ".TBL_OWNERSHIP.
                " WHERE ownerid='$userid'");
  $ret = array();
  while($row = $out->fetch_assoc())
    array_push($ret, $row['prodid']);
  return $ret;
}
?>