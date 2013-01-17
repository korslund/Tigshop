<?php
// This because PHP is fundamentally stupid
require_once 'config.php';

class MySQL_Setup
{
  private $mysqli;

  // Constructor
  function MySQL_Setup()
  {
    $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
      or $this->fail();
  }

  function fail()
  {
    die("DB ERROR: " . $this->mysqli->error);
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

function db_run($query)
{
  global $g_db;
  return $g_db->run($query);
}

function db_run_array($query)
{
  return db_run($query)->fetch_assoc();
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