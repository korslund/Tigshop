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
           price decimal(5,2),
           index owner_index(ownerid),
           index prod_index(prodid))");
}

function db_addPurchase($ownerid, $prodid, $price)
{
  $ownerid = db_esc($ownerid);
  $prodid = db_esc($prodid);
  $price = db_esc($price);

  db_run("INSERT INTO ".TBL_OWNERSHIP.
         "(ownerid,prodid,purchase_date,price)".
         " VALUES('$ownerid', '$prodid', NOW(), '$price')");
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
?>