<?php

include "../connect.php";

$email = filterRequest("email");
$verify = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM `users` WHERE `users_email` = '$email' AND `users_verifycode` = '$verify'");

$stmt->execute();

$count = $stmt->rowCount();

if($count > 0){

    $data = array("users_approve" => "1");
    updateData("users", $data, "users_email = '$email'");

}else {

    printFailure("Verification code entered not correct");
    
}


?>