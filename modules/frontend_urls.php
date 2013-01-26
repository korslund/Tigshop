<?php
require_once 'config.php';

function do_redirect($where)
{
  header("Location: ".$where);
  exit;
}
function _base($local) { return BASE_URL.$local; }

function url_home() { return _base(""); }
function url_admin() { return _base("admin/"); }
function url_userhome() { return _base("home.php"); }
function url_buy($query="") { return _base("buy.php".$query); }
function url_addkey($query="") { return _base("addkey.php".$query); }

function redirect_home() { do_redirect(url_home()); }
function redirect_admin() { do_redirect(url_admin()); }
function redirect_userhome() { do_redirect(url_userhome()); }
function redirect_buy($query="") { do_redirect(url_buy($query)); }
function redirect_addkey($query="") { do_redirect(url_addkey($query)); }

function makeLink($url, $text, $class="")
{
  $res = '<a ';
  if($class)
    $res .= 'class="'.$class.'" ';
  $res .= 'href="'.htmlentities($url).'">'.htmlentities($text).'</a>';
  return $res;
}
?>