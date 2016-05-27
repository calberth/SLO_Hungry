<?php
//Requested URL : http://localhost/SLO_Hungry/api/submit_comment
// Include confi.php
include_once('confi.php');

$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) :  "";
$restaurant = isset($_POST['restaurant']) ? mysql_real_escape_string($_POST['restaurant']) :  "";
$comment = isset($_POST['comment']) ? mysql_real_escape_string($_POST['comment']) :  NULL;
$price = isset($_POST['price']) ? mysql_real_escape_string($_POST['price']) :  NULL;
$rating = isset($_POST['rating']) ? mysql_real_escape_string($_POST['rating']) :  NULL;

if (!is_null($price) || !is_null($rating) || !is_null($comment)) {

   $query = "SELECT id FROM Profiles WHERE email = '$email';";
   $userID = mysql_result($query, 0)
   $query = "SELECT id FROM Restaurants WHERE name = '$restaurant';";
   $restID = mysql_result($query, 0)


   // Insert data into data base
   $sql = "INSERT INTO reviews VALUES (NULL, '$userID', '$restID', '$comment', '$price', '$rating');";
   $qur = mysql_query($sql);
         
   if ($qur) {
      $json = array("status" => 1, "msg" => "Comment added!");
   }
   else {
      $json = array("status" => 0, "msg" => "Error adding comment4!");
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