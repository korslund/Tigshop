<?php
require 'modules/frontend.php';

html_user_header("The Indie Game Shop", true);

if(isset($_POST['prodid']))
  {
    tg_requireNoncePOST("addgame");

    /* TODO: Sanitation galore. This is obviously not production code.
     */
    $prodid = $_POST['prodid'];
    $price = $_POST['price'];
    $title = $_POST['title'];
    $paypal = $_POST['paypal'];

    require 'modules/db_product.php';
    db_addProduct($prodid, $g_userid, $price, $title, $paypal, 15);

    // Always add ourself as an owner of our own products, at price 0.
    require 'modules/db_ownership.php';
    db_addPurchase($g_userid, $prodid, 0);

    echo '<p>Game added!</p>';
  }

echo '<p>Add a game to the database. This page exists just for testing purposes.</p>';
?>
<form action="addgame.php" method="post">
ID: <input name="prodid" type="text"/><br>
Price: <input name="price" type="text"/><br>
Title: <input name="title" type="text"/><br>
Paypal: <input name="paypal" type="text"/><br>
<input value="Create" type="submit"/>
<?php tg_printFormNonce("addgame"); ?>
</form>
<?

html_footer();
?>