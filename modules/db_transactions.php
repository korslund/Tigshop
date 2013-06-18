<?php
require_once 'db_setup.php';

define("TBL_TRANSACTIONS", "tigshop_transactions");

function db_createTransactionTable()
{
  db_run("DROP TABLE IF EXISTS " . TBL_TRANSACTIONS);

  db_run("CREATE TABLE " . TBL_TRANSACTIONS .
         "(tid int unsigned auto_increment,
           sender int unsigned,
           receiver int unsigned,
           amount decimal(5,2),
           details text,
           status tinyint(1) unsigned,
           what varchar(12),
           tdate datetime,
           index send_index(sender),
           index rec_index(receiver))");
}

function db_addTransaction($sendid, $recid, $amount, $details, $status, $what)
{
  $sendid = int($sendid);
  $recid = int($recid);
  $amount = db_esc($amount);
  $details = db_esc($details);
  $status = int($status);
  $what = db_esc($what);

  db_run("INSERT INTO ".TBL_TRANSACTIONS.
         "(sender, receiver, amount, details, status, what, tdate) ".
         "VALUES('$sendid', '$recid', '$amount', '$details', '$status', '$what', NOW())");
}

function db_listTransactionsBySender($sender)
{
  $sender = int($sender);
  return db_run_multi("SELECT * FROM ".TBL_TRANSACTIONS." WHERE sender='$sender'");
}

function db_listTransactionsByReceiver($receiver)
{
  $receiver = int($receiver);
  return db_run_multi("SELECT * FROM ".TBL_TRANSACTIONS." WHERE receiver='$receiver'");
}
?>