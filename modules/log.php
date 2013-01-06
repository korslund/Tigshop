<?php
require_once("config.php");

// Generate a log file from the current date
$tg_log_file = "tigshop-" . date("Y-m-d", mktime()) . ".log";

// Place log file in the config-defined log directory.
$tg_log_file = LOG_DIR . $tg_log_file;

/* Append one line to the log file. A newline is added.

   TODO: It's possible that adding file locking will be necessary at
   some point.
 */
function tg_write_line($msg)
{
  global $tg_log_file;

  $fd = fopen($tg_log_file, "a");
  fwrite($fd, $msg . "\n");
  fclose($fd);
}

/* Get the current date
 */
function tg_get_date()
{
  return date("Y-m-d H:i:s", mktime());
}

/* Get client IP adress. We need to test this.
 */
function tg_get_ip()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
    $ip=$_SERVER['HTTP_CLIENT_IP'];

  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

  else
    $ip=$_SERVER['REMOTE_ADDR'];

  return $ip;
}

/* Returns the entire added info string for the log message.
 */
function tg_get_log_info()
{
  return "[" . tg_get_date() . "] " . tg_get_ip() . " {" . $_SERVER['REQUEST_URI'] . "} ";
}

// Send the admin a mail
function tg_sendAdminMail($msg)
{
  $subject = "IMPORTANT: TIGShop admin message";
  $body = "This is a high-priority log message from TIGShop\n\n"
    ."The following message was logged and was deemed important\n"
    ."enough to warrant an admin email:\n\n".
    $msg;

  return mail(ADMIN_EMAIL,$subject,$body,"");
}

/* Main log function.

   If the second parameter (optional) is true, this is a serious log
   message. Send ourselves an email.
 */
function tg_log($msg, $email = false)
{
  $msg = tg_get_log_info() . $msg;
  tg_write_line($msg);
  if($email) tg_sendAdminMail($msg);
}
?>