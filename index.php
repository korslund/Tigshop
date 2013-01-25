<?php
require 'modules/frontend.php';

html_user_header("The Indie Game Shop");

?>
<p>Hello there!</p>
<p>Tigshop is an experimental new game shop, portal, thingie. We are
currently very hush-hush secretive and sneaky.</p>
<p>You can find all our games through <a href="http://tiggit.net/">The Indie Game Installer</a>.
<p>If you would like to sell your games here, request an invite:
<form action="invite.php" method="post">
Email: <input name="email" type="text"/> <input value="Send" type="submit"/>
<?php tg_printFormNonce("email_invite");?>
</form>
<?php
html_footer();
?>