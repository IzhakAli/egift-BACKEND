<?php 

include "../../connect.php" ; 

$sql = "SELECT
orders_id,
orders_usersid,
orders_rating,
COALESCE(orders_noterating, 'No comment provided') AS orders_noterating
FROM
orders
WHERE
orders_rating IS NOT NULL
OR orders_noterating IS NOT NULL
ORDER BY
orders_id DESC;";

// Prepare the statement
$stmt = $con->prepare($sql);

// Execute the statement
$stmt->execute();

 $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();

        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
?>