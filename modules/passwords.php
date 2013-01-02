<?php

define("HASH_ALGO", "sha512");
define("SALT_SIZE", "64");

/* Hash the given password using the user-configured algorithm and
   a key. Returns $salt . $hash
 */
function hashPassword($pass, $salt, $key)
{
  assert(strlen($salt) == SALT_SIZE);
  $hash = hash_hmac("sha512", $pass . $salt, $key);
  return $salt . $hash;
}

/* Check whether $clear hashes to the correct hashed password. Returns
   true for match, false otherwise.
 */
function checkPassword($db_hash, $clear, $key)
{
  // Get the salt
  $salt = substr($db_hash, 0, SALT_SIZE);

  // Hash the password
  $newhash = hashPassword($clear, $salt, $key);

  // Return true on match
  return ($newhash == $db_hash);
}

/**
 * generateRandStr - Generates a string made up of randomized
 * letters (lower and upper case) and digits, the length
 * is a specified parameter.
 */
function generateRandStr($length)
{
  $randstr = "";
  for($i=0; $i<$length; $i++)
    {
      $randnum = mt_rand(0,61);
      if($randnum < 10)      $randstr .= chr($randnum+48);
      else if($randnum < 36) $randstr .= chr($randnum+55);
      else                   $randstr .= chr($randnum+61);
    }
  return $randstr;
}

/**
 * generateRandomID - Generates a string made up of randomized letters
 * (lower and upper case) and digits and returns the md5 hash of
 * it. Not used for passwords but used for the session id among other
 * things.
 */
function generateRandomID()
{
  return md5(generateRandStr(16));
}
   
// Make a salt string of the proper length
function makeSalt()
{
  return generateRandStr(SALT_SIZE);
}

/* Create a new hash from a password. This will generate a new salt to
   go along with the password as well.
 */
function createHash($pass, $key)
{
  $salt = makeSalt();
  return hashPassword($pass, $salt, $key);
}
?>