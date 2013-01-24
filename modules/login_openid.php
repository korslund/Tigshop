<?php

function login_openid($domain, $ident)
{
  $retval = array();
  $retval['type'] = 'openid';
  $retval['valid'] = false;

  require_once 'openid.php';

  $openid = new LightOpenID($domain);

  if(!$openid->mode)
    {
      $openid->identity = $ident;
      $openid->required = array('contact/email');
      header('Location: ' . $openid->authUrl());
      $retval['status'] = 'ask';
    }
  elseif($openid->mode == 'cancel')
    {
      $retval['status'] = 'cancel';
    }
  else
    {
      if($openid->validate())
        {
          // Login was validated
          $retval['valid'] = true;
          $retval['status'] = 'ok';
          $retval['openid'] = $openid->identity;
          $attrib = $openid->getAttributes();
          $retval['email'] = $attrib['contact/email'];
        }
      else
        {
          $retval['status'] = 'failed';
        }
    }
  return $retval;
}

/* Call this to request a login using Google.

   May redirect to an off-site page, for that reason HAS to precede
   any other output on the page. In case of a redirect, the caller
   page will be invoked again, and the function will behave
   differently based on GET parameters.

   Throws on error.
 */
function login_google($domain)
{
  $retval = login_openid($domain, 'https://www.google.com/accounts/o8/id');
  $retval['provider'] = 'google';
  return $retval;
}
?>