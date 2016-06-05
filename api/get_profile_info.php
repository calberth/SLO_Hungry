<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_profile_info

// Include confi.php
include_once('confi.php');

$uId = isset($_POST['uId']) ? intval(mysql_real_escape_string($_POST['uId'])) :  "";

$query = "SELECT * FROM Profiles
   WHERE id = '$uId'
;";

$result = mysql_query($query);

if (mysql_num_rows($result) == 1) {
   while ($row = mysql_fetch_assoc($result)) {
      $json = array("status" => 1, "name" => $row['name']);
   }
}
else {
   $json = array("status" => 0, "msg" => "No Profile Found  $uId");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>