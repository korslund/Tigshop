<?php
require 'modules/frontend.php';
require 'modules/db_product.php';

html_user_header("The Indie Game Shop");

$games = db_listProducts();

echo 'All games:<br><br>';
foreach($games as $gid)
  {
    echo '<b>',$gid,'</b>:<br>';
    $prod = db_getProduct($gid);
    // TODO: Price is no longer part of the product
    echo htmlentities($prod['title']),/*' $',$prod['price'],*/'<br>owner=',$prod['ownerid'],
      ' paypal=',$prod['paypal'],'<br><br>';
  }

html_footer();
?>