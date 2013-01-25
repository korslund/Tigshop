<?php
/*
  This script redirects a browser to pages that handle various
  requests. The user may be asked to sign in or create a new account
  along the way.

  GET parameters:

  - key: if present, request that the user enables the given API
    key.

  - want: list of items the user wants to buy, separated by plus
    signs.

  If more than one parameter is present, the site will try its best to
  deal with the requests sequentially.
 */

$key = urlencode(@$_GET['key']);
$want = urlencode(@$_GET['want']);

require '../modules/frontend_urls.php';

if($key != "")
  {
    // Go to API key insertion first
    $query = "?key=$key";
    if($want != "")
      $query .= "&want=$want";

    redirect_addkey($query);
  }
elseif($want != "")
  {
    // No key. Go directly to purchase page.
    $query = "?want=$want";

    redirect_buy($query);
  }

die("Invalid parameters");
?>