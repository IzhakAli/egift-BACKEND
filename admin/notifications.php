<?php 

include '../connect.php';

$title = filterRequest('title');
$message = filterRequest('message');
// $topic = filterRequest('topic');




sendGCM("$title", "$message" , "users", "", "");
printSuccess();
?>