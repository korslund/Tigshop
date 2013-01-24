<?php
/*
  Main functions responsible for dispensing and checking form nonces
  (one-use number tokens used to protect against CSRF attacks.)

  We might create a more advanced system later, to allow multiple
  nonces for the same page. Some users will want to do things
  simultaneously through multiple tabs or windows.
 */

require_once('passwords.php');
require_once('log.php');

/*******************************************************
    NONCE PRODUCTION

*******************************************************/

// Generate and set a session nonce value. Returns the nonce.
function tg_makeNonce($form)
{
  if(session_id() == '') session_start();
  $nonce = generateRandomID();
  $_SESSION['NONCE_' . $form] = $nonce;
  assert($nonce != "");
  return $nonce;
}

// Return a form input field containing the nonce information
function tg_getFormNonce($form)
{
  $nonce = tg_makeNonce($form);
  return '<input type="hidden" name="nonce" value="' . $nonce . '">';
}

// Echo the field from tg_getFormNonce directly.
function tg_printFormNonce($form)
{
  $str = tg_getFormNonce($form);
  echo $str;
}

/*******************************************************
    NONCE CONFIRMATION

*******************************************************/

// Return true if the given nonce checks out.
function tg_checkNonce($form, $nonce)
{
  $name = 'NONCE_' . $form;

  // Were we given a nonce?
  if($nonce != "")
    {
      // Lazy-start the session on demand
      if(session_id() == '') session_start();

      // Does it check out OK?
      if(isset($_SESSION[$name]) && $_SESSION[$name] == $nonce)
        return true;
    }

  return false;
}

function tg_checkNoncePOST($form)
{
  if(isset($_POST['nonce']))
    return tg_checkNonce($form, $_POST['nonce']);
  return false;
}

function tg_checkNonceGET($form)
{
  if(isset($_GET['nonce']))
    return tg_checkNonce($form, $_GET['nonce']);
  return false;
}

// Check if the given nonce is correct. Use a blank nonce to force an
// error.
function tg_requireNonce($form, $nonce)
{
  if(tg_checkNonce($form, $nonce))
    return;

  // Nonce failed

  // Log this - potential CSRF attack
  tg_log("WARNING: Form nonce '$form' failed - from '" . $_SERVER['HTTP_REFERER'] . "'. ".
         "Wanted '".$_SESSION[$name]."', got '$nonce'");

  die("Internal error. Please reload and try again.");
}

// Check if the nonce in POST is correct, fail if it isn't.
function tg_requireNoncePOST($form)
{
  // Did POST come with a nonce?
  if(isset($_POST['nonce']))
    // If so, test it
    tg_requireNonce($form, $_POST['nonce']);
  else
    // Otherwise, fail
    tg_requireNonce($form, "");
}

// Check if the nonce in GET is correct, fail if it isn't.
function tg_requireNonceGET($form)
{
  // Did GET come with a nonce?
  if(isset($_GET['nonce']))
    // If so, test it
    tg_requireNonce($form, $_GET['nonce']);
  else
    // Otherwise, fail
    tg_requireNonce($form, "");
}
?>