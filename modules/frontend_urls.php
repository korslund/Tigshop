<?php
require_once 'config.php';

function _redirect($where)
{
  header("Location: ".$where);
  exit;
}
function _base($local) { return BASE_URL.$local; }

function url_home() { return _base(""); }
function url_userhome() { return _base("home.php"); }
function url_logout() { return _base("login/logout.php"); }
function url_create() { return _base("login/create.php"); }
function url_login() { return _base("login/"); }
function url_login_google() { return _base("login/google.php"); }
function url_login_email() { return _base("login/email.php"); }

function redirect_home() { _redirect(url_home()); }
function redirect_userhome() { _redirect(url_userhome()); }
function redirect_login($redir)
{ _redirect(url_login() . "?redir=$redir"); }
function redirect_create() { _redirect(url_create()); }

/* Redirect based on a keyword.
 */
function redirect_keyword($key)
{
  if($key == "userhome") redirect_userhome();
  redirect_home();
}

/* Store a redirect location in _SESSION for later use.
 */
function redirect_set_session($key)
{
  $_SESSION['tigshop_redir_key'] = $key;
}

/* Redirect to the value previously set in _SESSION
 */
function redirect_session()
{
  $key = $_SESSION['tigshop_redir_key'];
  unset($_SESSION['tigshop_redir_key']);
  redirect_keyword($key);
}
?>