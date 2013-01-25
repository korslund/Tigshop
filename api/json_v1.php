<?php
require '../modules/db_apikey.php';
require '../modules/db_user.php';

/* Parameters and results:

   - key: request user information. Requires that the key is a
     registered authorization key for a user.

   - key+want: request download link for one item described in
     'want'. The key is used to authenticate the request.

   Future additions (NOT IMPLEMENTED):

   - userid+password: obtain a new key for this user by providing
     login info directly. This requires a password-enabled account to
     already exist. Returns user info and the new key.
 */

/* This is the response array. We pile on additional information as
   required, then return it encoded as a JSON string.
 */
$res = array();

// Mark the response with the current date & time
date_default_timezone_set('UTC');
$res['generated'] = date("Y-m-d H:i:s", mktime())." UTC";

function api_return($type, $msg)
{
  global $res;

  $res['type'] = $type;
  if($msg != "") $res['message'] = $msg;

  // Print the response
  header('Content-type: application/json');
  print json_encode($res);
  exit;
}

function api_message($msg = "") { api_return("message", $msg); }
function api_error($msg) { api_return("error", $msg); }
function api_authfail($msg) { api_return("authfail", $msg); }

function add_userinfo($userid, $nick, $auth, $items)
{
  global $res;
  $res['userinfo'] = array("userid" => $userid,
                           "nickname" => $nick,
                           "authname" => $auth,
                           "items" => $items);
}

// Check the key first
if(!isset($_GET['key']))
  api_error("Invalid parameters");

$key = $_GET['key'];
$newkey = '';

// Check the key
$keyinfo = db_API_checkKey($key);

if(!$keyinfo)
  api_authfail("Your authentication key was not recognized");

// Add the new key to output, if there was one
if(isset($keyinfo['newkey']))
  $res['newkey'] = $keyinfo['newkey'];

// Set user info
$userid = $keyinfo['userid'];
$authname = $keyinfo['desc'];

// Look up the user
$userinfo = db_getUser($userid);

if(!$userinfo || !$userinfo['valid'])
  api_authfail("The specified user is not valid");

// Set further user info
$nick = $userinfo['nickname'];

if(isset($_GET['want']))
  {
    // We are making a download link. Get the item we are fetching.
    $item = $_GET['want'];

    // Test
    if($item == "abc")
      api_message("http://go.get/$item");
    else
      api_error("You do not have access to this item");

    // TODO: Validate item name
    // TODO: Look up if the user has access to this game
    // TODO: then produce a valid link and return it
  }
else
  {
    // We are returning user info

    // TODO: Get real item string here
    $itemString = "one+two+three";
    add_userinfo($userid, $nick, $authname, $itemString);
    api_message();
  }
?>