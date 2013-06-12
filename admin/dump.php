<?php
require '../modules/admin_page.php';
require_once '../modules/db_user.php';
require_once '../modules/db_auth.php';
require '../modules/db_ownership.php';
require '../modules/db_product.php';

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
print json_encode($res);
?>