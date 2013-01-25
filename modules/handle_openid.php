<?php

require 'login_openid.php';

// This will handle all incoming OpenID returns
$ret = receive_openid(DOMAIN_NAME);

/* URL to redirect to if login succeeds. This is provied for us as
   a GET parameter.
*/
$retURL = $_GET['openid_return_to'];

if($ret['status'] == "ok")
  {
    require 'handle_login_common.php';
    $ret = login_email($ret['email'], true);

    // Handle the return value
    handle_login_ret($ret, $retURL);
  }

$retURL = htmlentities($retURL);

require_once 'frontend_urls.php';
?>
<p>The OpenID login failed or was canceled.</p>
<p>Return <a href="<?php echo url_home();?>">Home</a><br>
You came from: <a href="<?php echo $retURL;?>"><?php echo $retURL;?></a>
</p>