<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_favs.php
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$id = isset($_POST['uid']) ? mysql_real_escape_string($_POST['uid']) :  "";
$page = isset($_POST['page']) ? intval(mysql_real_escape_string($_POST['page'])) * 10 :  "";


$query = "SELECT R.name, R.id FROM Profiles P
   JOIN Favorites F ON P.id = F.userID
   JOIN Restaurants R ON R.id = F.restuarantId
   WHERE P.id = $id
   LIMIT $page, 10
;
";

$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $restaurants = array();
   while ($row = mysql_fetch_assoc($result)) {
      array_push($restaurants, array('name' => $row['name'], 'rid' => $row['id']));
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