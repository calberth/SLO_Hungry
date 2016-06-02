<?php
//Requested URL : http://localhost/SLO_Hungry/api/submit_comment
// Include confi.php
include_once('confi.php');

$uId = isset($_POST['uId']) ? intval(mysql_real_escape_string($_POST['uId'])) :  NULL;
$rId = isset($_POST['rId']) ? intval(mysql_real_escape_string($_POST['rId'])) :  NULL;
$comment = isset($_POST['comment']) ? mysql_real_escape_string($_POST['comment']) :  'NULL';
$price = isset($_POST['price']) ? intval(mysql_real_escape_string($_POST['price'])) :  'NULL';
$rating = isset($_POST['rating']) ? intval(mysql_real_escape_string($_POST['rating'])) :  'NULL';

if (!is_null($price) || !is_null($rating) || !is_null($comment)) {

   if (strcmp($comment, 'NULL') == 0) {
      $sql = "INSERT INTO reviews VALUES ($uId, $rId, $comment, $price, $rating, NOW());";
   }
   else {
      $sql = "INSERT INTO reviews VALUES ($uId, $rId, '$comment', $price, $rating, NOW());";
   }

   $qur = mysql_query($sql);
         
   if ($qur) {
      $json = array("status" => 1, "msg" => "Comment added!");
   }
   else {
      $json = array("status" => 0, "msg" => "Error adding comment! $uId  $rId $comment $price  $rating");
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