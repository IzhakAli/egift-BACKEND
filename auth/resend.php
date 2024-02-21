<?php

include "../connect.php";

$verifycode     = rand(10000, 99999);
$email = filterRequest("email");

$data = array(
    "users_verifycode" => $verifycode
);

updateData("users", $data ,"users_email = '$email'");

sendEmail($email, "eGift Email Verification","Your verification code is $verifycode");
?>