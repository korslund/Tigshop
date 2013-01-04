<?php
require 'module/frontend_urls.php';

function append_line($file, $line)
{
  $fd = fopen($file, "a");
  fwrite($fd, $line . "\n");
  fclose($fd);
}

$email = $_POST['email'];

append_line(INVITE_FILE, $email);

redirect_home();
?>