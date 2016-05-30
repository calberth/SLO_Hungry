<?php
//Requested URL : http://localhost/SLO_Hungry/api/get_user_comments?email=[email]&page=[email]
 //Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$email = isset($_GET['email']) ? mysql_real_escape_string($_GET['email']) :  "";
$page = isset($_GET['page']) ? intval(mysql_real_escape_string($_GET['page'])) * 10 :  "";

$query = "SELECT v.name, R.comment, R.rating, R.price FROM Profiles P
   JOIN Reviews R ON P.id = R.userId
   JOIN Restaurants V ON V.id = R.restId
   WHERE email = '$email'
   LIMIT $page, 10 
;";


$result = mysql_query($query);

$json = array();
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
   $json = array("status" => 0, "msg" => "No Comments $page");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>