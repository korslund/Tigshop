<?php
require 'modules/frontend_urls.php';
require 'modules/nonce.php';

function append_line($file, $line)
{
  $fd = fopen($file, "a");
  fwrite($fd, $line . "\n");
  fclose($fd);
}

tg_requireNoncePOST("email_invite");

$email = $_POST['email'];

append_line(INVITE_FILE, $email);

redirect_home();
?>