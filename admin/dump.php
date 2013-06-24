<?php
require '../modules/admin_page.php';
require_once '../modules/db_user.php';
require_once '../modules/db_auth.php';
require '../modules/db_ownership.php';
require '../modules/db_product.php';
require '../modules/db_transactions.php';
require '../modules/db_line_desc.php';
require '../modules/db_line_products.php';
require '../modules/db_line_userlevels.php';

header('Content-type: application/json');

$res = array();

function dump_table($table)
{
  return db_run_multi("SELECT * FROM " . $table);
}

date_default_timezone_set('UTC');
$res['generated'] = date("Y-m-d H:i:s", mktime())." UTC";

$res['users'] = dump_table(TBL_USERS);
$res['auth'] = dump_table(TBL_AUTH);
$res['ownership'] = dump_table(TBL_OWNERSHIP);
$res['products'] = dump_table(TBL_PRODUCTS);
$res['transactions'] = dump_table(TBL_TRANSACTIONS);
$res['line_desc'] = dump_table(TBL_LINE_DESC);
$res['line_products'] = dump_table(TBL_LINE_PRODUCTS);
$res['line_userlevel'] = dump_table(TBL_LINE_USERLEVEL);

print json_encode($res);
?>