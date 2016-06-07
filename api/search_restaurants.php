<?php
//Requested URL : http://localhost/SLO_Hungry/api/search_restaurants.php
//[filter] is optional. Options are hi, lo, rating   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$fid= isset($_POST['fid']) ? mysql_real_escape_string($_POST['fid']) :  "";
$page = isset($_POST['page']) ? intval(mysql_real_escape_string($_POST['page'])) * 10 :  "";
$filter = isset($_POST['filter']) ? mysql_real_escape_string($_POST['filter']) :  "";


if (strcmp($filter, "hi") == 0) {
   $query = "SELECT T.name, T.image, T.id, T.rating, numRatings, rat, price FROM (
       SELECT R.name, R.image, R.id, R.rating FROM FoodRestaurants RF
         JOIN Food F ON RF.foodId = F.id
         JOIN Restaurants R ON RF.restuarantID = R.id
         WHERE F.id = '$fid'
      ) T
       LEFT JOIN (
           SELECT restId, COUNT(*) AS numRatings, AVG(rating) AS rat, FLOOR(AVG(price)) AS price FROM Reviews
           GROUP BY restId
       ) S ON S.restid = T.id
       GROUP BY T.id
       ORDER BY price DESC
       LIMIT $page, 10
   ;";
}
else if (strcmp($filter, "lo") == 0) {
   $query = "SELECT T.name, T.image, T.id, T.rating, numRatings, rat, price FROM (
       SELECT R.name, R.image, R.id, R.rating FROM FoodRestaurants RF
         JOIN Food F ON RF.foodId = F.id
         JOIN Restaurants R ON RF.restuarantID = R.id
         WHERE F.id = '$fid'
      ) T
       LEFT JOIN (
           SELECT restId, COUNT(*) AS numRatings, AVG(rating) AS rat, FLOOR(AVG(price)) AS price FROM Reviews
           GROUP BY restId
       ) S ON S.restid = T.id
       GROUP BY T.id
       ORDER BY price
       LIMIT $page, 10
   ;";
}
else if (strcmp($filter, "rating") == 0) {
   $query = "SELECT T.name, T.image, T.id, T.rating, numRatings, rat, price FROM (
       SELECT R.name, R.image, R.id, R.rating FROM FoodRestaurants RF
         JOIN Food F ON RF.foodId = F.id
         JOIN Restaurants R ON RF.restuarantID = R.id
         WHERE F.id = '$fid'
      ) T
       LEFT JOIN (
           SELECT restId, COUNT(*) AS numRatings, AVG(rating) AS rat, FLOOR(AVG(price)) AS price FROM Reviews
           GROUP BY restId
       ) S ON S.restid = T.id
       GROUP BY T.id
       ORDER BY rating DESC
       LIMIT $page, 10
   ;";
}
else {
   $query = "SELECT T.name, T.image, T.id, T.rating, numRatings, rat, price FROM (
       SELECT R.name, R.image, R.id, R.rating FROM FoodRestaurants RF
         JOIN Food F ON RF.foodId = F.id
         JOIN Restaurants R ON RF.restuarantID = R.id
         WHERE F.id = '$fid'
      ) T
       LEFT JOIN (
           SELECT restId, COUNT(*) AS numRatings, AVG(rating) AS rat, FLOOR(AVG(price)) AS price FROM Reviews
           GROUP BY restId
       ) S ON S.restid = T.id
       GROUP BY T.id
       LIMIT $page, 10
   ;";
}


$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = $filter;
   $restaurants = array();
   while ($row = mysql_fetch_assoc($result)) {
      $name = $row['name'];
      $image = $row['image'];
      $rid = $row['id'];
      $rating = $row['rating'];
      $rating = ($row["rat"] + ($rating * 100)) / (100 + $row['numRatings']);
      $numRatings = $row['numRatings'];
      $price = "";

      if (is_null($numRatings)) {
         $numRatings = 0;
      }

      if (is_null($row['price'])) {
         $price = "NA";
      }
      else {
         for ($x = 0; $x < $row["price"]; $x++) {
            $price .= '$';
         }
      }

      array_push($restaurants, array('name' => $name, 'image' => $image, 'price' => $price,
       'rating' => round($rating,2), 'numRatings' => $numRatings, 'rid' => $rid));
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