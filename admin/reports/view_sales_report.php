<?php 

include "../../connect.php" ; 

$startdate = filterRequest("startdate");
$enddate = filterRequest("enddate");


getAllData("report_sales_revenue", "order_date BETWEEN '$startdate' AND '$enddate'  ORDER BY `report_sales_revenue`.`order_date` DESC");

?>