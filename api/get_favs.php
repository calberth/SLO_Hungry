<?php
//Requested URL : http://localhost/SLO_Hungry/api/user_favs?user=[email]&page=[#]   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$email = isset($_GET['email']) ? mysql_real_escape_string($_GET['email']) :  "";
$page = isset($_GET['page']) ? intval(mysql_real_escape_string($_GET['page'])) * 10 :  "";


$query = "SELECT R.name FROM Profiles P
   JOIN Favorites F ON P.id = F.userID
   JOIN Restaurants R ON R.id = F.restaurantId
   WHERE P.email = '$email'
   LIMIT $page, 10
;
";

$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $restaurants = array();
   while ($row = mysql_fetch_assoc($result)) {
      array_push($restaurants, array('name' => $row['name']));
   }
   $json["restaurants"] = $restaurants;
}
else {
   $json = array("status" => 1, "msg" => "No Favorites");
}
   

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>