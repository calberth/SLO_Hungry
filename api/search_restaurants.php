<?php
//Requested URL : http://localhost/SLO_Hungry/api/search_restaurants.php
//[filter] is optional. Options are hi, lo, rating   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$fid= isset($_POST['fid']) ? mysql_real_escape_string($_POST['fid']) :  "";
$page = isset($_POST['page']) ? intval(mysql_real_escape_string($_POST['page'])) * 10 :  "";

$query = "SELECT R.name, R.image, R.id, R.rating FROM FoodRestaurants RF
   JOIN Food F ON RF.foodId = F.id
   JOIN Restaurants R ON RF.restuarantID = R.id
   WHERE F.id = $fid
   GROUP BY R.id
   LIMIT $page, 10
;";

$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $restaurants = array();
   while ($row = mysql_fetch_assoc($result)) {
      $name = $row['name'];
      $image = $row['image'];
      $rid = $row['id'];
      $rating = $row['rating'];

      $query = "SELECT COUNT(*) AS numRatings, AVG(rating) AS rat, FLOOR(AVG(price)) AS price FROM Reviews
         WHERE restId = $rid;";
      $qur = mysql_query($query);
      $restRow = mysql_fetch_assoc($qur);
      $rating = ($restRow["rat"] + ($rating * 100)) / (100 + $restRow['numRatings']);
      $price = "";
      if ($price == 0) {
         $price = "NA";
      }
      else {
         for ($x = 0; $x < $price; $x++) {
            $price .= '$';
         }
      }

      array_push($restaurants, array('name' => $name, 'image' => $image, 'price' => $price,
       'rating' => round($rating,2), 'numRatings' => $restRow['numRatings'], 'rid' => $rid));
   }

   //sort

   $json["restaurants"] = $restaurants;
   $query = "SELECT COUNT(*) AS count FROM (SELECT R.id FROM FoodRestaurants RF
      JOIN Food F ON RF.foodId = F.id
      JOIN Restaurants R ON RF.restuarantID = R.id
      WHERE F.id = 4
      GROUP BY R.id) T
   ;
   ";
   $result = mysql_query($query);
   while ($row = mysql_fetch_assoc($result)) {
      $json['count'] = $row['count'];
   }
}
else {
   $json = array("status" => 0, "msg" => "No Restaurants $page $fid $query");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>