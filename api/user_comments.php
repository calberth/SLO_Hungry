<?php
//Requested URL : http://localhost/SLO_Hungry/api/user_comments?user=[email]&page=[#]
//Returns only 10 favorites per page
include_once('confi.php');

$email = isset($_GET['email']) ? mysql_real_escape_string($_GET['email']) :  "";
$page = isset($_GET['page']) ? mysql_real_escape_string($_GET['page']) :  "";

if (!is_empty($price)) {

   $query = "SELECT RS.name, R.comment, R.price, R.rating FROM Profiles P
      JOIN Reviews R ON P.id = R.userID
      JOIN Restaurants RS ON RS.id = R.restId
      WHERE P.email = '$email'
      LIMIT ($page * 10), 10
   ;
   ";

   $result = mysql_query($query);

   $json = array();
   if (mysql_num_rows($result) != 0) {
      $json['status'] = 1;
      while ($row = mysql_fetch_assoc($result)) {
         $restaurant = $row["name"];
         $comment = $row['comment'];
         $review = $row['price'];
         $rating = $row['rating'];

         if (!is_null($comment) && !is_null($price) && !is_null($rating)) {
            $json['review'] = array('restaurant' => $restaurant,  'comment' => $comment,
               'price' => $review,  'rating' => $rating);
         }
         else if (!is_null($price) && !is_null($rating)) {
            $json['review'] = array('restaurant' => $restaurant, 'price' => $review,  'rating' => $rating);
         }
         else if (!is_null($comment) && !is_null($rating)) {
            $json['review'] = array('restaurant' => $restaurant, 'comment' => $comment,  'rating' => $rating);
         }
         else if (!is_null($comment) && !is_null($price)) {
            $json['review'] = array('restaurant' => $restaurant, 'comment' => $comment,  'price' => $price);
         }
         else if (!is_null($price)) {
            $json['review'] = array('restaurant' => $restaurant, 'price' => $review);
         }
         else if (!is_null($rating)) {
            $json['review'] = array('restaurant' => $restaurant, 'rating' => $rating);
         }
         else if (!is_null($comment)) {
            $json['review'] = array('restaurant' => $restaurant, 'comment' => $comment);
         }
      }
   }
   else {
      $json = array("status" => 1, "msg" => "No Favorites");
   }
   
}
else {
   $json = array("status" => 0, "msg" => "Invalid Request");
}


@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>