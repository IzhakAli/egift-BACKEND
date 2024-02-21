<?php

include "../connect.php";

$username = filterRequest("username");
$password = sha1(filterRequest("password"));
$email = filterRequest("email");
$phone = filterRequest("phone");
$verifycode     = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ? ");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("PHONE OR EMAIL Duplicated");
} else {

    $data = array(
        "users_name" => $username,
        "users_password" =>  $password,
        "users_email" => $email,
        "users_phone" => $phone,
        "users_verifycode" => $verifycode,
    );
    sendEmail($email, "eGift Email Verification","Your verification code is $verifycode");
    insertData("users" , $data) ; 

}