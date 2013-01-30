<?php
require 'modules/frontend.php';

if($g_loggedIn)
  {
    require 'modules/db_product.php';
    // Recieve POST information here.
  }

html_user_header("The Indie Game Shop", true);

echo '<p>Under construction</p>';

html_footer();
?>