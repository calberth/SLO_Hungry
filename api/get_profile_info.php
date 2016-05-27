<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_profile_info?uId=[uId]

// Include confi.php
include_once('confi.php');

$uId = isset($_GET['uId']) ? mysql_real_escape_string($_GET['uId']) :  "";

$query = 'SELECT * FROM Profiles
   WHERE id = '$uId'
;';

$result = mysql_query($query);

if (mysql_num_rows($result) == 1) {
   while ($row = mysql_fetch_assoc($result)) {
      $json = array("name" => $row['name']);
   }
}
else {
   $json = array("status" => 0, "msg" => "No Profile Found");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>