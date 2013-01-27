<?php
/*
  This script redirects a browser to pages that handle various
  requests. The user may be asked to sign in or create a new account
  along the way.

  GET parameters:

  - key: if present, request that the user enables the given API
    key. The key must be unique.

  - want: list of items the user wants to buy, separated by plus
    signs.

  - asuser: the userid that we are expecting to log in as. If we are
    logged in to another account, the user will be notified so they
    don't make a mistake.

  If more than one parameter is present, the site will try its best to
  deal with the requests sequentially.
 */

$key = urlencode(@$_GET['key']);
$want = urlencode(@$_GET['want']);
$asuser = urlencode(@$_GET['asuser']);

require '../modules/frontend_urls.php';

if($key != "")
  {
    // Go to API key insertion first
    $query = "?key=$key";
    if($want != "")
      $query .= "&want=$want";

    if($asuser != "")
      $query .= "&asuser=$asuser";

    redirect_addkey($query);
  }
elseif($want != "")
  {
    // No key. Go directly to purchase page.
    $query = "?want=$want";

    if($asuser != "")
      $query .= "&asuser=$asuser";

    redirect_buy($query);
  }

die("Invalid parameters");
?>