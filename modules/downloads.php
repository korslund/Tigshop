<?php
function dl_getItemLink($item)
{
  require 'amazon_s3.php';
  return s3_signedURL($item.".zip", 300);
}
?>