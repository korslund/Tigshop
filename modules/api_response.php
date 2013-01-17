<?php
/* Functions for constructing API responses. The arrays returned from
   these functions are passed to json_encode() and sent directly to
   output by the frontend API scripts.
 */

function add_gen_date(&$res)
{
  date_default_timezone_set('UTC');
  $nowTime = date("Y-m-d H:i:s", mktime())." UTC";
  $res['generated'] = $nowTime;
}

function api_pack($userid, $newkey, $data)
{
  $res = array("userid" => $userid,
               "data" => $data);
  if($newkey != "") $res['newkey'] = $newkey;
  add_gen_date($res);
  return $res;
}

function api_pack_userinfo($userid, $newkey, $nickname, $apidesc)
{
  return api_pack($userid, $newkey,
                  array("nickname" => $nickname,
                        "api_desc" => $apidesc));
}

function api_error($error, $details = "")
{
  $res = array("error" => $error);
  if($details != "")
    $res['details'] = $details;
  add_gen_date($res);
  return $res;
}

function api_error_key() { return api_error("key"); }
function api_error_access($details) { return api_error("access", $details); }

/* Return a value as JSON output. Since this calls header() and
   produces one complete json object, it should be the first and only
   output of the page.
 */
function api_json_output($value)
{
  header('Content-type: application/json');
  print json_encode($value);
}
?>