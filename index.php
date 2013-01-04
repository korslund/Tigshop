<?php
require 'modules/frontend_header.php';
require 'modules/frontend_autologin.php';
html_header("The Indie Game Shop");
html_user_bar();
?>
<p>Hello there!</p>
<p>Tigshop is an experimental new game shop, portal, thingie. We are
currently very hush-hush secretive and sneaky.</p>
<p>You can find all our games through <a href="http://tiggit.net/">The Indie Game Installer</a>.
<p>If you would like to sell your games here, request an invite:
<form action="invite.php" method="post">
Email: <input name="email" type="text"/> <input value="Send" type="submit"/>
</form>
<?php
html_footer();
?>