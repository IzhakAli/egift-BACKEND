<?php

include "../connect.php";

$email = filterRequest("email");
$verifycode     = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();
result($count);

if ($count > 0) {
    
    $data = array("users_verifycode" => $verifycode); 

    updateData("users", $data, "users_email = '$email'",false);//the false is to not send succes becuase it is already send through the $result variable
    sendEmail($email, "eGift Email Verification","Your verification code is $verifycode");
}
