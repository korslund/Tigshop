<?php
require '../modules/frontend.php';
require '../modules/admin_page.php';
require_once '../modules/db_user.php';
require_once '../modules/db_auth.php';
require_once '../modules/auth_code.php';
require_once '../modules/frontend_urls.php';
require '../modules/db_ownership.php';
require '../modules/db_product.php';

// Consider more security checks and user confirmations here
if(isset($_GET['action']))
  {
    $act = $_GET['action'];
    $val = $_GET['value'];

    tg_requireNonceGET("admin_action");

    if($act == "delete")
      {
        tg_log("Deleting userid $val");
        db_killUser($val);
        db_killAuthUser($val);
        db_removeLogin($val);
      }
    elseif($act == "become")
      {
        if($val != $g_userid)
          doLogin($val, true);

        redirect_userhome();
      }
    elseif($act == "assign")
      {
        $user = $_GET['user'];
        $prod = db_getProduct($val);

        if($prod && db_getUser($user))
          db_addPurchase($user, $val);
      }
  }

html_user_header("The Indie Game Shop", true);

echo '<p>If you see this, you are viewing an admin page!</p>';

$users = db_listUsers();
$nonce = tg_makeNonce("admin_action");

echo 'Users:<br>';
foreach($users as $uid)
  {
    $auths = db_getAuthList($uid);

    echo "<b>User $uid:</b> ";
    if($uid == $g_userid) echo "this is you";
    else echo "<a href=\"index.php?action=become&value=$uid&nonce=$nonce\">become</a>";
    echo " <a href=\"index.php?action=delete&value=$uid&nonce=$nonce\">delete</a><br>\n";
    foreach($auths as $auth)
      echo disp_auth($auth)."<br>\n";
    echo '<br>';
  }
?>
<p>Assign game to user:</p>
<form action="index.php" method="get">
Game: <input name="value" type="text"/>
User: <input name="user" type="text"/>
<input type="hidden" name="nonce" value="<?php echo $nonce;?>"/>
<input type="hidden" name="action" value="assign"/>
<input value="Assign" type="submit"/>
</form>
<?php
html_footer();
?>