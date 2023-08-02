<?php
require 'vendor/autoload.php'; 

use Twilio\Rest\Client;

$sid = 'AC660c8a24d890a51ac80a5c7596f3e69b';
$token = '77e017877e0bb072ec662303d8ca0950';
$twilioNumber = '+19894872593'; 

function verifyPhoneNumber($phoneNumber) {
    global $sid, $token, $twilioNumber;

    $client = new Client($sid, $token);

    try {
        $lookup = $client->lookups->v1->phoneNumbers($phoneNumber)->fetch();
        return $lookup->phoneNumber;
    } catch (Exception $e) {
        return false;
    }
}
?>
