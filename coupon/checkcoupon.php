<?php 

include "../connect.php" ; 

$couponName = filterRequest("couponname") ; 

$now = date("YYYY-MM-DD hh:mm:ss");

getData("coupon", "coupon_name = '$couponName' AND coupon_expiredate > '$now' AND coupon_count > 0  ");
?>