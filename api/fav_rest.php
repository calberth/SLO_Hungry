<?php
//Requested URL : http://localhost/SLO_Hungry/api/fav_rest.php   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$uid = isset($_POST['uid']) ? mysql_real_escape_string($_POST['uid']) :  "";
$rid = isset($_POST['rid']) ? mysql_real_escape_string($_POST['rid']) :  "";


$query = "INSERT INTO Favorites VALUES ($uid, $rid)";

$result = mysql_query($query);

if ($result) {
   $json = array("status" => 1);
}
else {
   $json = array("status" => 1);
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>