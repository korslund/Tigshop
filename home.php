<?php
require 'modules/frontend_header.php';
require 'modules/frontend_autologin.php';

require_login("userhome");

html_header("The Indie Game Shop");
html_user_bar();
?>
<p>You are home</p>
<?php

// TODO: Put in an 'ago' part as well
echo '<p>Account created: '.$g_user_info['creation_date'].'</p>';

html_footer();
?>