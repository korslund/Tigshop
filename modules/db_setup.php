<?php
require_once '../secret/config.php';

class MySQL_Setup
{
  private $con;

  // Constructor
  function MySQL_Setup()
  {
    $this->con = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or $this->fail();
    mysql_select_db(DB_NAME, $this->con) or $this->fail();
  }

  function fail()
  {
    die("DB ERROR: " . mysql_error());
  }

  function run($query)
  {
    $res = mysql_query($query, $this->con) or $this->fail();
    return $res;
  }
};

$g_db = new MySQL_Setup;

function db_run($query)
{
  global $g_db;
  return $g_db->run($query);
}
?>