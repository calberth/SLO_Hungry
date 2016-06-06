<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_user_comments.php
 //Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$uId = isset($_POST['uId']) ? intval(mysql_real_escape_string($_POST['uId'])) :  "";
$page = isset($_POST['page']) ? intval(mysql_real_escape_string($_POST['page'])) * 10 :  "";

$json = array();

$query = "SELECT COUNT(*) AS count FROM Profiles P
   JOIN Reviews R ON P.id = R.userId
   JOIN Restaurants V ON V.id = R.restId
   WHERE P.id = $uId
;";

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$json["count"] = $row["count"];

$query = "SELECT V.name, R.comment, R.rating, R.price FROM Profiles P
   JOIN Reviews R ON P.id = R.userId
   JOIN Restaurants V ON V.id = R.restId
   WHERE P.id = $uId
   LIMIT $page, 10 
;";


$result = mysql_query($query);

if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $comments = array();
   while ($row = mysql_fetch_assoc($result)) {
      $restaurant = $row["name"];
      $comment = $row['comment'];
      $price = $row['price'];
      $rating = $row['rating'];
      if (!is_null($comment) && !is_null($price) && !is_null($rating)) {
         array_push($comments, array('name' => $restaurant, 'comment' => $comment, 'price' => $price,
          'rating' => $rating));
      }
      else if (!is_null($price) && !is_null($rating)) {
        array_push($comments, array('restaurant' => $restaurant, 'price' => $price,  'rating' => $rating));
      }
      else if (!is_null($comment) && !is_null($rating)) {
         array_push($comments, array('restaurant' => $restaurant, 'comment' => $comment,  'rating' => $rating));
      }
      else if (!is_null($comment) && !is_null($price)) {
         array_push($comments, array('restaurant' => $restaurant, 'comment' => $comment,  'price' => $price));
      }
      else if (!is_null($price)) {
         array_push($comments, array('restaurant' => $restaurant, 'price' => $price));
      }
      else if (!is_null($rating)) {
         array_push($comments, array('restaurant' => $restaurant, 'rating' => $rating));
      }
      else if (!is_null($comment)) {
         array_push($comments, array('restaurant' => $restaurant, 'comment' => $comment));
      }
   }
   $json["comments"] = $comments;
}
else {
<<<<<<< HEAD
   $json = array("status" => 0, "msg" => "No Comments");
   $json["count"] = $row["count"];
=======
   $json = array("status" => 0, "msg" => "No Comments $page  $uId", "count" => 0);
>>>>>>> 5cd3ca798b69f1b07ee09dbafe355bab03a9c573
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>