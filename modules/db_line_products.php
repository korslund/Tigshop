<?php
require_once 'db_setup.php';

define("TBL_LINE_PRODUCTS", "tigshop_line_products");

function db_createLineProductsTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_LINE_PRODUCTS);

  db_run("CREATE TABLE " . TBL_LINE_PRODUCTS .
         "(lineid int unsigned,
           prodid varchar(32),
           price decimal(5,2),
           index line_index(lineid),
           primary key (prodid,lineid))");
}

function db_addProductToLine($prodid, $lineid, $price)
{
  $prodid = db_esc($prodid);
  $lineid = db_esc($lineid);
  $price = db_esc($price);

  db_run("INSERT INTO ".TBL_LINE_PRODUCTS.
         "(lineid, prodid, price) ".
         "VALUES('$lineid', '$prodid', '$price')");
}

function db_removeProductFromLine($prodid, $lineid)
{
  $prodid = db_esc($prodid);
  $lineid = db_esc($lineid);
  db_run("DELETE FROM ".TBL_LINE_PRODUCTS." WHERE prodid='$prodid' AND lineid='$lineid'");
}

function db_updateProductPrice($prodid, $lineid, $price)
{
  $prodid = db_esc($prodid);
  $lineid = db_esc($lineid);
  $price = db_esc($price);

  db_run("UPDATE ".TBL_LINE_PRODUCTS.
         " SET price='$price'".
         " WHERE prodid='$prodid' AND lineid='$lineid'");
}

// Returns -1 if not found
function db_getProductPrice($prodid, $lineid)
{
  $prodid = db_esc($prodid);
  $lineid = db_esc($lineid);
  $res = db_run_array("SELECT price FROM ".TBL_LINE_PRODUCTS." WHERE prodid='$prodid' AND lineid='$lineid'");

  if($res) return $res['price'];
  else return -1;
}

function db_listLineProducts($lineid)
{
  $lineid = db_esc($lineid);
  return db_run_multi("SELECT prodid,price FROM ".TBL_LINE_PRODUCTS." WHERE lineid='$lineid'");
}

?>