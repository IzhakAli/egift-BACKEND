<?php

include "../../connect.php";

$orderid = filterRequest("ordersid");

$userid = filterRequest("usersid");

$data = array(
    "orders_status" => 1
);

updateData("orders", $data, "orders_id = $orderid AND orders_status = 0");

// sendGCM("success" , "The Order Has been Approved" , "users$userid" , "none" , "refreshorderpending"); 

insertNotify("success", "Your Order is being revised", $userid, "users$userid", "none",  "refreshorderpending");
