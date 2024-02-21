<?php

include "../connect.php";

$userid = filterRequest("usersid");


$data = getAllData("cartview", "cart_usersid = $userid", null, false);

$stmt = $con -> prepare("SELECT SUM(itemsprice) AS totalprice, SUM(countitems) as totalcount FROM `cartview`
WHERE cartview.cart_usersid = $userid
GROUP BY cart_usersid");

$stmt -> execute();

$datacountprice = $stmt ->fetch(PDO::FETCH_ASSOC); //only fetches on row which is enough

echo json_encode(array(
    "status" => "success",
    "datacart" => $data,
    "countprice" => $datacountprice
));

?>