<?php
require_once 'db_setup.php';

define("TBL_PRODUCTS", "tigshop_products");

/* Set up the database table. Not called during normal operation.
 */
function db_createProductTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_PRODUCTS);

  db_run("CREATE TABLE " . TBL_PRODUCTS .
         "(prodid varchar(32) primary key,
           creation_date datetime,
           ownerid int unsigned,
           price decimal(5,2),
           title text,
           paypal text,
           provision int,
           index owner_index(ownerid))");
}

/* Create a new product entry.
 */
function db_addProduct($prodid, $owner, $price, $title, $paypal, $provision)
{
  $prodid = db_esc($prodid);
  $owner = db_esc($owner);
  $price = db_esc($price);
  $title = db_esc($title);
  $paypal = db_esc($paypal);
  $provision = db_esc($provision);

  db_run("INSERT INTO ".TBL_PRODUCTS.
         "(prodid, creation_date, ownerid, price, title, paypal, provision) ".
         "VALUES('$prodid', NOW(), '$owner', '$price', '$title', '$paypal', '$provision')");
}

/* Update an existing product entry.
 */
function db_setProductInfo($prodid, $owner, $price, $title, $paypal, $provision)
{
  $prodid = db_esc($prodid);
  $owner = db_esc($owner);
  $price = db_esc($price);
  $title = db_esc($title);
  $paypal = db_esc($paypal);
  $provision = db_esc($provision);

  db_run("UPDATE ".TBL_PRODUCTS.
         " SET ownerid='$owner', price='$price', title='$title', paypal='$paypal', provision='$provision'".
         " WHERE prodid='$prodid'");
}

/* Get product info. Returns an associative array, or 'false' if no such
   product was found.
 */
function db_getProduct($prodid)
{
  $prodid = db_esc($prodid);
  $res = db_run_array("SELECT * FROM ".TBL_PRODUCTS." WHERE prodid='$prodid'");
  return $res;
}

/* List all products. Outputs an array of prodids.
 */
function db_listProducts()
{
  $out = db_run("SELECT prodid FROM ".TBL_PRODUCTS);
  $ret = array();
  while($row = $out->fetch_assoc())
    array_push($ret, $row['prodid']);
  return $ret;
}

/* Kill a product
 */
function db_killProduct($prodid)
{
  $prodid = db_esc($prodid);
  db_run("DELETE FROM ".TBL_PRODUCTS." WHERE prodid='$prodid'");
}
?>