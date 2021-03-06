<?php
require_once 'log.php';
require_once 'db_line_desc.php';
require_once 'db_line_products.php';
require_once 'db_line_userlevels.php';
require_once 'db_ownership.php';
require_once 'db_transactions.php';

function makePayment($buyer, $lineid, $amount, $details)
{
  tg_log("makePayment(buyer=U$buyer, lineid=L$lineid, amount=$amount, details='$details')");

  $line = db_getLine($lineid);
  if(!$line)
    {
      tg_log("Invalid lineid L$lineid", true);
      return -1;
    }

  $receiver = (int)$line['ownerid'];
  if($receiver == 0)
    {
      tg_log("Line L$lineid had no ownerid", true);
      return -1;
    }

  if($amount != (real)$amount || $amount <= 0)
    {
      tg_log("amount=$amount is not a valid price value", true);
      return -1;
    }

  $level = db_getUserLevel($buyer, $lineid);
  $newlevel = $level + $amount;
  if(!($level >= 0) || !($newlevel > 0) || !($amount > 0))
    {
      tg_log("Invalid userlevel: level=$level amount=$amount sum=$newlevel userid=U$buyer lineid=L$lineid", true);
      return -1;
    }

  tg_log("Setting user level for U$buyer on L$lineid: $level => $newlevel");
  db_setUserLevel($buyer, $lineid, $newlevel);

  $all_products = db_listLineProducts($lineid);
  foreach($all_products as $prod)
    {
      $prodid = $prod['prodid'];
      $price = $prod['price'];
      if($price <= $newlevel && !db_isOwner($buyer, $prodid))
        {
          tg_log("Adding U$buyer as owner of P$prodid (price $price)");
          db_addOwner($buyer, $prodid);
        }
    }

  $tid = db_addTransaction($buyer, $receiver, $amount, $details, 1, 'L'.$lineid);
  tg_log("Finished makePayment() for buyer=U$buyer: TID=$tid");
  return $tid;
}
?>