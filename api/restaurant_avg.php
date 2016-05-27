<?php
//Requested URL : http://localhost/SLO_Hungry/api/restaurant_avg.php?restaurant=[restaurant]
// Include confi.php
include_once('confi.php');

$restaurant = isset($_POST['restaurant']) ? mysql_real_escape_string($_POST['restaurant']) :  "";;

$query = "SELECT AVG(rating) FROM restaurants R
   JOIN reviews V ON R.id = V.restId
   WHERE R.name = '$restaurant'
;
";

$result = mysql_query($query);

$json = array("status" => 1, "msg" => mysql_result($result, 0));

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>