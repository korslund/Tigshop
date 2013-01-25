<?php

function create_openid_return($openid)
{
  $retval = array();
  $retval['type'] = 'openid';

  if(!$openid->mode)
    die("Expected OpenID credentials");
  elseif($openid->mode == 'cancel')
    {
      $retval['status'] = 'cancel';
    }
  else
    {
      if($openid->validate())
        {
          // Login was validated
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

// Handle incoming OpenID parameters from GET or POST
function receive_openid($domain)
{
  require_once 'openid.php';
  $openid = new LightOpenID($domain);
  return create_openid_return($openid);
}

/* Create a login request and redirect to an external openid
   service. The service will redirect back to the same page, where you
   may either call this function again or call receive_openid()
   explicitly.
 */
function login_openid($domain, $ident)
{
  require_once 'openid.php';
  $openid = new LightOpenID($domain);

  if(!$openid->mode)
    {
      $openid->identity = $ident;
      $openid->required = array('contact/email');
      header('Location: ' . $openid->authUrl());
      exit;
    }

  // If we did not redirect, then assume we are handling incoming data
  return create_openid_return($openid);
}

/* Call this to request a login using Google.
 */
function login_google($domain)
{
  login_openid($domain, 'https://www.google.com/accounts/o8/id');
}
?>