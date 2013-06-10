<?php

// Input
$line = "line1+line2";
$price = "3.14+1.23";
$userid = "123"; // Can be missing
$paypal = "paypal@email.com";
$apikey = "abcd"; // Optional

// TODO: Sanitize and log

// Things to deduce from the input
$email = "";

if($userid == "")
  {
    // Get or create a user from email
    $userid = userFromEmail($paypal);
  }
else
  {
    // Otherwise, look up the user and get relevant info
    $email = "xyz";
  }

// Send to paypal address if no user-associated email was found
if($email == "") $email = $paypal;

// Add the requested API key to the account
if($apikey != "")
  addAPIKey($userid, $apikey);

// TODO: Logging and error reporting in all the steps above and below

// Next, look up the product line(s)
$info = lookupProdLine($line);

// TODO: Fail if not valid (however since we're doing this in a loop,
// failure means remembering the error and continuing)

// TODO: Update payment status on this product line

// TODO: Find all products unlocked by this purchase

// TODO: Then unlock them for this user

/* VERY important thing: we need to intercept broken DB connections so
   that they send me a more unique email message. We can't just abort,
   we have to send me the details on email.
 */

/* Finally, send the user a thank-you mail informing them of
   everything they have paid for (or an error mail if something went
   wrong.)

   Make sure to mention that we've created an account for them. 
 */

?>