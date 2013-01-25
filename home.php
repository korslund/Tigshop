<?php
require 'modules/frontend.php';
require_once 'modules/frontend_urls.php';
require_once 'modules/auth_code.php';
require_once 'modules/db_auth.php';
require 'modules/db_apikey.php';

if($g_loggedIn)
  {
    if(isset($_POST['nick']))
      {
        tg_requireNoncePOST("home_setnick");
        db_setUserInfo($g_userid, $_POST['nick']);
        redirect_userhome();
      }

    if(isset($_POST['kill_api_key']))
      {
        tg_requireNoncePOST("api_key");
        db_API_killKey($_POST['kill_api_key'], $g_userid);
      }
    elseif(isset($_POST['name_api_key']))
      {
        tg_requireNoncePOST("api_key");
        db_API_nameKey($_POST['name_api_key'], $_POST['new_name']);
      }
    elseif(isset($_POST['add_api_key']))
      {
        tg_requireNoncePOST("api_key");
        db_API_addKey($_POST['add_api_key'], $_POST['new_name'], $g_userid);
      }
  }

html_user_header("The Indie Game Shop", true);

$nick = htmlentities($g_user_info['nickname']);
?>
<p>You are home</p>
<form action="home.php" method="post">
Nickname: <input name="nick" type="text" value="<?php echo $nick;?>"/>
<input value="Change name" type="submit"/>
<?php
tg_printFormNonce("home_setnick");
echo '</form>';
// Debug display:
echo '<br>new_auth: '.disp_auth($_SESSION['new_auth']);
echo '<br>add_auth: '.disp_auth($_SESSION['add_auth']);
echo '<br>cur_auth: '.disp_auth($g_cur_auth);

// TODO: Put in an 'ago' part as well
echo '<p>Account created: '.$g_user_info['creation_date'].'</p>';

$list = db_getAuthList($g_userid);
echo '<p>Your IDs:</p>';
foreach($list as $auth)
  {
    echo disp_auth($auth).'<br>';
  }

echo '<p>Tiggit API keys:</p>';
$list = db_API_listKeys($g_userid);
$nonce = tg_getFormNonce("api_key");
foreach($list as $apikey)
  {
    $key = htmlentities($apikey['key']);
    $desc = htmlentities($apikey['desc']);
?>
<form action="home.php" method="post">
<?php echo $key; ?>
<input name="name_api_key" type="hidden" value="<?php echo $key;?>"/>
<input name="new_name" type="text" value="<?php echo $desc;?>"/>
<input value="Change name" type="submit"/>
<?php echo $nonce; ?>
</form>
<form action="home.php" method="post">
<input name="kill_api_key" type="hidden" value="<?php echo $key;?>"/>
<input value="Delete" type="submit"/>
<?php echo $nonce; ?>
</form>
<?php
  }
?>
<p>Add new key:</p>
<form action="home.php" method="post">
Key: <input name="add_api_key" type="text"/>
Description: <input name="new_name" type="text"/>
<input value="Add" type="submit"/>
<?php echo $nonce; ?>
</form>
<?php
html_footer();
?>