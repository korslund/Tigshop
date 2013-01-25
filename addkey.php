<?php
require 'modules/frontend.php';

html_user_header("Authorize Application - The Indie Game Shop", true);

if(!isset($_GET['key']))
  die("Missing parameter");

$want = urlencode(@$_GET['want']);
if($want)
  $buyURL = url_buy("?want=$want");

if(isset($_POST['addkey']))
  {
    tg_requireNoncePOST("addkey");

    $key = $_POST['addkey'];
    $name = @$_POST['name'];

    if($_GET['key'] != $key)
      die("Parameter mismatch");

    // WAIT: add key exactly like we do in home.php
    echo "KEY=$key<br>NAME=$name<br>";

    // Redirect to the buy page if there's a shopping list
    if($want)
      do_redirect($buyURL);

    echo "You're done!";
    html_footer();
    exit;
  }

require_once 'modules/urltools.php';

$key = htmlentities($_GET['key']);
$url = get_this_url();
if($want)
  {
    $cancelName = "Skip";
    $cancelURL = $buyURL;
  }
else
  {
    $cancelName = "Cancel";
    $cancelURL = url_userhome();
  }
?>
You are trying to add a key.<br>
Key: <?php echo $key;?><br>
<form action="<?php echo $url;?>" method="post">
Optional key name: <input type="text" name="name"/><br>
<input type="submit" value="Approve"/>
<input type="hidden" name="addkey" value="<?php echo $key;?>"/>
<?php tg_printFormNonce("addkey");?>
</form>
<form action="<?php echo $cancelURL;?>" method="post">
<button><?php echo $cancelName;?></button></form>
<?php
html_footer();
?>