<?php 

include "../connect.php" ; 


$userid = filterRequest("id") ; 


getAllData('ordersview' , "orders_usersid = '$userid' AND orders_status =  4 ORDER BY orders_datetime DESC;"); 

 
    
?>