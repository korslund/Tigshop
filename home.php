<?php
require 'modules/frontend_header.php';
require 'modules/frontend_autologin.php';
require_once 'modules/frontend_urls.php';
require_once 'modules/auth_code.php';
require_once 'modules/db_auth.php';
require 'modules/nonce.php';

require_login("userhome");

if(isset($_GET['nick']))
  {
    tg_requireNonceGET("home_setnick");
    db_setUserInfo($g_userid, $_GET['nick']);
    redirect_userhome();
  }

html_header("The Indie Game Shop");
html_user_bar();

$nick = htmlentities($g_user_info['nickname']);
?>
<p>You are home</p>
<form action="home.php" method="get">
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
html_footer();
?>