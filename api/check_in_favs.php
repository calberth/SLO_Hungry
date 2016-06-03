<?php
//Requested URL : http://localhost/SLO_Hungry/api/check_in_favs.php   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$uid = isset($_POST['uid']) ? mysql_real_escape_string($_POST['uid']) :  "";
$rid = isset($_POST['rid']) ? mysql_real_escape_string($_POST['rid']) :  "";


$query = "SELECT COUNT(*) AS count FROM Profiles P
   JOIN Favorites F ON P.id = F.userID
   JOIN Restaurants R ON R.id = F.restuarantId
   WHERE P.id = $uid AND R.id = $rid
;
";

$result = mysql_query($query);

$json = array();


while ($row = mysql_fetch_assoc($result)) {
   $json = array('count' => $row['count']);
}

   

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>