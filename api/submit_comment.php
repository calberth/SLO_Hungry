<?php
//Requested URL : http://localhost/SLO_Hungry/api/submit_comment
// Include confi.php
include_once('confi.php');

$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) :  NULL;
$restaurant = isset($_POST['restaurant']) ? mysql_real_escape_string($_POST['restaurant']) :  "";
$comment = isset($_POST['comment']) ? mysql_real_escape_string($_POST['comment']) :  NULL;
$price = isset($_POST['price']) ? mysql_real_escape_string($_POST['price']) :  NULL;
$rating = isset($_POST['rating']) ? mysql_real_escape_string($_POST['rating']) :  NULL;

if (!is_null($price) || !is_null($rating) || !is_null($comment)) {

   if (!is_null($email)) {
      $query = "SELECT id FROM Profiles WHERE email = '$email';";
      $result = mysql_query($query);
      $userID = mysql_result($result, 0);
   }
   //submit as guest
   else {
      $userID = 1;
   }

   $query = "SELECT id FROM Restaurants WHERE name = '$restaurant';";
   $result = mysql_query($query);
   $restID = mysql_result($result, 0);


   // Insert data into data base
   $sql = "INSERT INTO reviews VALUES ('$userID', '$restID', '$comment', '$price', '$rating');";
   $qur = mysql_query($sql);
         
   if ($qur) {
      $json = array("status" => 1, "msg" => "Comment added!");
   }
   else {
      $json = array("status" => 0, "msg" => "Error adding comment!");
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