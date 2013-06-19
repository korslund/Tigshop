<?php
function makePayment($buyer, $lineid, $amount, $details)
{
  require_once 'db_line_desc.php';
  require_once 'db_line_products.php';
  require_once 'db_line_userlevels.php';
  require_once 'db_ownership.php';
  require_once 'db_transaction.php';

  // TODO: Replace this with real log function, and with email
  // required.

  $line = db_getLine($lineid);
  if(!$line)
    {
      log("Invalid lineid L$lineid");
      return -1;
    }

  $receiver = (int)$line['ownerid'];
  if($receiver == 0)
    {
      log("Line L$lineid had no ownerid");
      return -1;
    }

  // TODO: Sanitize amount: must be a number and > 0

  $level = db_getUserLevel($buyer, $lineid);
  $newlevel = $level + $amount;
  if(!($level > 0) || !($newlevel > 0) || !($amount > 0))
    {
      log("Invalid userlevel: level=$level amount=$amount sum=$newlevel userid=U$buyer lineid=L$lineid");
      return -1;
    }

  log("Setting user level for U$buyer on L$lineid: $level => $newlevel");
  db_setUserLevel($buyer, $lineid, $newlevel);

  $all_products = $db_listLineProducts($lineid);
  foreach($all_products as $prod)
    {
      $prodid = $prod['prodid'];
      $price = $prod['price'];
      if($price <= $newlevel && !db_isOwner($buyer, $prodid))
        {
          log("Adding U$buyer as owner of P$prodid (price $price)");
          db_addOwner($buyer, $prodid);
        }
    }

  $tid = db_addTransaction($buyer, $receiver, $amount, $details, 1, 'L'.$lineid);
}
?>