<?php
require_once 'config.php';

class MySQL_Setup
{
  private $mysqli;

  var $error_prepend;

  // Constructor
  function MySQL_Setup()
  {
    $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
      or $this->fail();
    $error_prepend = "";
  }

  function fail()
  {
    $err = $this->error_prepend . "DB ERROR: " . $this->mysqli->error;
    tg_log($err, true);
    die("A temporary database error occured. Please contact the site administrator if the error persists.");
  }

  function run($query)
  {
    $res = $this->mysqli->query($query) or $this->fail();
    return $res;
  }

  function esc($str)
  {
    return $this->mysqli->real_escape_string($str);
  }

  function getId()
  {
    return $this->mysqli->insert_id;
  }
};

$g_db = new MySQL_Setup;

function db_set_error_prepend($msg)
{
  global $g_db;
  $g_db->error_prepend = $msg;
}

function db_run($query)
{
  global $g_db;
  return $g_db->run($query);
}

function db_run_count($query)
{
  return db_run($query)->num_rows;
}

function db_run_array($query)
{
  return db_run($query)->fetch_assoc();
}

function db_run_multi($query)
{
  $out = db_run($query);
  $ret = array();
  while($row = $out->fetch_assoc())
    array_push($ret, $row);
  return $ret;
}

function db_esc($str)
{
  global $g_db;
  return $g_db->esc($str);
}

function db_getId()
{
  global $g_db;
  return $g_db->getId();
}
?>