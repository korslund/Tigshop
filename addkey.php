<?php
require 'modules/frontend.php';

/* TODO: html_user_header() can have an option of what text to display
   to non-logged in users, depending on context. Something like:

   STEP 1: sign in to tigshop (is redisplayed later but grayed out)
   STEP 2: grant access to your games
   STEP 3: purchase games
*/

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

    // Add the key to the database
    require 'modules/db_apikey.php';
    db_API_addKey($key, $name, $g_userid);

    // Redirect to the buy page if there's a shopping list
    if($want)
      do_redirect($buyURL);

    echo "<p>Access has been granted to key ".htmlentities($key)."!</p>";
    echo "<p>You can manage your access key on the ".makeLink(url_userhome(), "user settings page")."</p>\n";
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
<p>An external application wants access to your Tigshop account.</p>
<p>Access key: <?php echo $key;?></p>
<h3>PERMISSIONS:</h3>
<p>This application wants to:</p>
<ul>
<li>See non-sensitive user info (userid, nickname)</li>
<li>See the list of games you own</li>
<li>Download games you own</li>
</ul>
<form action="<?php echo $url;?>" method="post">
<p>Optional: Name this key: <input type="text" name="name"/> (Eg.: "Tiggit on laptop")</p>
<p>Naming your keys will makes it easier to identify them later if you have more than one.</p><br>
<input type="submit" value="Approve"/>
<input type="hidden" name="addkey" value="<?php echo $key;?>"/>
<?php tg_printFormNonce("addkey");?>
</form>
<form action="<?php echo $cancelURL;?>" method="post">
<button><?php echo $cancelName;?></button></form>
<?php
html_footer();
?>