<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_rest_byId

// Include confi.php
include_once('confi.php');

$rId = isset($_POST['rId']) ? mysql_real_escape_string($_POST['rId']) :  "";

$query = "SELECT * FROM Restaurants
   WHERE id = '$rId'
;";

$result = mysql_query($query);

if (mysql_num_rows($result) == 1) {
   while ($row = mysql_fetch_assoc($result)) {
      $json = array('id' => $row['id'], "name" => $row['name'], "location" => $row['location'], "hours" => $row['hours'],
       "image" => $row['image'], "website" => $row['website'], "phone" => $row['phone'], 'rating' => $row['rating'],
       "status" => 1, "long" => $row['longitude'], "lat" => $row['latitude']);
   }
}
else {
   $json = array("status" => 0, "msg" => "No restaurant Found");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>