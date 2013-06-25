<?php

// Input
$line = "line1+line2";
$price = "3.14+1.23";
$paypal = "paypal@email.com";
$userid = "123"; // Can be missing
$apikey = "abcd"; // Optional

// TODO: Sanitize and log

// TODO: Create a description string that describes this
// transaction. Includes 'PP', payer email and txn_id

// TODO: We also need duplication checks for repeated transactions.

// TODO: Fill this with useful information
db_set_error_prepend("CRITICAL: An error occured during a transaction (123)\n\nError message: ");

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

// TODO: Logging and error reporting in all the steps above and below

// TODO: make_purchase

// Add the requested API key to the account
if($apikey != "")
  addAPIKey($userid, $apikey);

/* Finally, send the user a thank-you mail informing them of
   everything they have paid for (or an error mail if something went
   wrong.)

   Make sure to mention if we've created an account for them.
 */

?>