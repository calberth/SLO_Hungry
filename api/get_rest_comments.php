<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_rest_comments
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$restId = isset($_POST['rId']) ? mysql_real_escape_string($_POST['rId']) :  "";
$page = isset($_POST['page']) ? intval(mysql_real_escape_string($_POST['page'])) * 10 :  "";

$query = "SELECT V.name, R.comment, R.rating, R.price, P.name AS profile, P.id AS pId 
FROM Profiles P
   JOIN Reviews R ON P.id = R.userId
   JOIN Restaurants V ON V.id = R.restId
   WHERE V.id = '$restId'
   LIMIT $page, 10  
;";


$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $comments = array();
   while ($row = mysql_fetch_assoc($result)) {
      array_push($comments, array('name' => $row['name'], 'comment' => $row['comment'], 'price' => $row['price'],
       'rating' => $row['rating'], 'userName' => $row['profile'], 'pId' => $row['pId']));
   }
   $json["comments"] = $comments;
}
else {
   $json = array("status" => 0, "msg" => "No Comments");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>