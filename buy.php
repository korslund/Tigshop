<?php
require 'modules/frontend.php';
require 'modules/db_product.php';

if(!isset($_GET['want']))
  die("Missing parameter");

$list = explode(' ', htmlentities($_GET['want']));

html_user_header("Buy Game - The Indie Game Shop");

if(!$g_loggedIn)
  {
    echo '<p>Warning: TigShop assigns your purchases to your email address. You are <b>not logged in</b>, so purchased games will be assigned to your <b>PayPal email address</b>. You can change this by logging in.</p>';
  }

echo '<p>List:</p><ul>';
$sum = 0;
$cut = 0;
foreach($list as $item)
  {
    $prodInfo = db_getProduct($item);

    if(!$prodInfo)
      html_die("<br><b>ERROR:</b> Unknown item $item!");

    $title = htmlentities($prodInfo['title']);
    // TODO: This has moved
    //$price = $prodInfo['price'];
    $price = 999;
    $prov = $prodInfo['provision'];

    $cut += $prov*$price;

    echo '<li>',$title,': $',$price,'</li>';

    $sum += $price;
  }
echo '</ul>';
echo 'SUM: $',$sum;
echo '<br>CUT: $',($cut/100.0);

html_footer();
?>