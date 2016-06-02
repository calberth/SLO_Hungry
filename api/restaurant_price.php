<?php
//Requested URL : http://localhost/SLO_Hungry/api/restaurant_price.php
// Include confi.php
include_once('confi.php');

$rId = isset($_POST['rId']) ? mysql_real_escape_string($_POST['rId']) :  "";

$query = "SELECT AVG(price) AS price FROM restaurants R
   JOIN reviews V ON R.id = V.restId
   WHERE R.id = '$rId'
;
";

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
   $json = array('price' => $row['price']);
}

$json = array("status" => 1, "price" => mysql_result($result, 0));

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>