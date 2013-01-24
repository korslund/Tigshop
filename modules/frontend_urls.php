<?php
require_once 'config.php';

function do_redirect($where)
{
  header("Location: ".$where);
  exit;
}
function _base($local) { return BASE_URL.$local; }

function url_home() { return _base(""); }
function url_userhome() { return _base("home.php"); }
function url_admin() { return _base("admin/"); }

function redirect_home() { do_redirect(url_home()); }
function redirect_admin() { do_redirect(url_admin()); }
function redirect_userhome() { do_redirect(url_userhome()); }
?>