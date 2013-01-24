<?php

/* Get the full URL to the current page. Note that this is intended
   for Apache. Some parts such as REQUEST_URI might not work on IIS.

   SECURITY WARNING: The page url is USER INPUT. Never EVER display or
   use it without htmlentities() or other necessary sanitation.
 */
function get_this_url()
{
  $host = $_SERVER['HTTP_HOST'];

  $newURL = 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://';

  // Add host name
  $newURL .= $_SERVER['HTTP_HOST'];

  // Preserve non-standard ports as well
  $port = $_SERVER['SERVER_PORT'];
  if($port != "80")
    $newURL .= ':'.$port;

  // Finally add the URI
  $newURL .= $_SERVER['REQUEST_URI'];

  return $newURL;
}

function url_add_get($url, $varname, $value="")
{
  $pos = strpos($url, "?");
  $vars = array();
  $new_url = $url;
  if($pos !== false)
    {
      $new_url = substr($url, 0, $pos);
      $query = substr($url, $pos+1);
      parse_str($query, $vars);
    }
  $vars[$varname] = $value;
  $query = http_build_query($vars);
  if($query != "")
    $new_url .= "?" . $query;
  return $new_url;
}

function url_remove_get($url, $varname)
{
  $pos = strpos($url, "?");
  $vars = array();
  $new_url = $url;
  if($pos !== false)
    {
      $new_url = substr($url, 0, $pos);
      $query = substr($url, $pos+1);
      parse_str($query, $vars);
    }
  if(isset($vars[$varname]))
    unset($vars[$varname]);
  $query = http_build_query($vars);
  if($query != "")
    $new_url .= "?" . $query;
  return $new_url;
}
?>