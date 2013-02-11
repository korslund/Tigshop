<?php
require_once 'config.php';

/* Generate a hash signature to pass to S3
 */
function s3_sign($str)
{
  return base64_encode(hash_hmac('sha1', $str, S3_SECRET_KEY, true));
}

/* Get a signed URL for a private object

   The 'seconds' param specifies how many seconds (from now) the link
   will be valid.
 */
function s3_signedURL($object, $seconds)
{
  $bucket = S3_BUCKET;

  // URI request
  $objres = '/' . $bucket . '/' . str_replace('%2F', '/', rawurlencode($object));

  // Calculate expiry time
  $expires = strtotime("+$seconds seconds");

  // Generate the string to sign
  $sign = "GET\n\n\n";
  $sign .= $expires . "\n";
  $sign .= $objres;

  // Create a hashed signature
  $signature = s3_sign($sign);

  $url = S3_HOSTNAME . $objres;
  $url .= '?AWSAccessKeyId=' . S3_KEY;
  $url .= '&Expires=' . $expires;
  $url .= '&Signature=' . rawurlencode($signature);
  return $url;
}
?>