<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_restaurant_info

// Include confi.php
include_once('confi.php');

$restaurant = isset($_POST['restaurant']) ? mysql_real_escape_string($_POST['restaurant']) :  "";

$query = 'SELECT * FROM Restaurants
   WHERE name = '$restaurant'
;';

$result = mysql_query($query);

if (mysql_num_rows($result) == 1) {
   while ($row = mysql_fetch_assoc($result)) {
      $json = array("name" => $row['name'], "location" => $row['location'], "hours" => $row['hours'],
       "image" => $row['image'], "website" => $row['website']);
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