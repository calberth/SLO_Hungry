<?php
//Requested URL : http://localhost/SLO_Hungry/api/restaurant_avg.php
// Include confi.php
include_once('confi.php');

$rId = isset($_POST['rId']) ? mysql_real_escape_string($_POST['rId']) :  "";;

$query = "SELECT AVG(V.rating) AS rating, COUNT(*) AS count FROM restaurants R
   JOIN reviews V ON R.id = V.restId
   WHERE R.id = '$rId'
;
";

$result = mysql_query($query);

$json = array('status' => 0);

while ($row = mysql_fetch_assoc($result)) {
   $json = array('rating' => $row['rating'], 'count' => $row['count']);
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>