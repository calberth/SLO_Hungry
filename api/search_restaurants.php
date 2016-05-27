<?php
//Requested URL : http://localhost/SLO_Hungry/api/search_restaurants?food=[type]&filter=[filter]&page=[page]
//[filter] is optional. Options are hi, lo, rating   
//Returns only 10 favorites per page
// Include confi.php
include_once('confi.php');

$food = isset($_GET['food']) ? mysql_real_escape_string($_GET['food']) :  "";
$filter = isset($_GET['filter']) ? mysql_real_escape_string($_GET['filter']) :  "";
$page = isset($_GET['page']) ? intval(mysql_real_escape_string($_GET['page'])) :  "";

if (strcmp($filter, 'hi') == 0) {
   $query = "SELECT R.name, R.image, AVG(V.price) AS price, AVG(V.rating) AS rating, COUNT(*) AS numRatings
   FROM FoodRestaurants RF
      JOIN Food F ON RF.foodId = F.id
      JOIN Restaurants R ON RF.restaurantID = R.id
      JOIN Reviews V ON R.id = V.restId
      WHERE food = '$food'
      GROUP BY R.id
      ORDER BY AVG(V.price) DESC
      LIMIT ($page * 10), 10
   ;
   ";
}
else if (strcmp($filter, 'lo') == 0) {
   $query = "SELECT R.name, R.image, AVG(V.price) AS price, AVG(V.rating) AS rating, COUNT(*) AS numRatings
   FROM FoodRestaurants RF
      JOIN Food F ON RF.foodId = F.id
      JOIN Restaurants R ON RF.restaurantID = R.id
      JOIN Reviews V ON R.id = V.restId
      WHERE food = '$food'
      GROUP BY R.id
      ORDER BY AVG(V.price)
      LIMIT ($page * 10), 10
   ;
   ";
}
else if (strcmp($filter, 'rating') == 0) {
   $query = "SELECT R.name, R.image, AVG(V.price) AS price, AVG(V.rating) AS rating, COUNT(*) AS numRatings
   FROM FoodRestaurants RF
      JOIN Food F ON RF.foodId = F.id
      JOIN Restaurants R ON RF.restaurantID = R.id
      JOIN Reviews V ON R.id = V.restId
      WHERE food = '$food'
      GROUP BY R.id
      ORDER BY AVG(V.rating) DESC
      LIMIT ($page * 10), 10
   ;
   ";
}
else {
   $query = "SELECT R.name, R.image, AVG(V.price) AS price, AVG(V.rating) AS rating, COUNT(*) AS numRatings
   FROM FoodRestaurants RF
      JOIN Food F ON RF.foodId = F.id
      JOIN Restaurants R ON RF.restaurantID = R.id
      JOIN Reviews V ON R.id = V.restId
      WHERE food = '$food'
      GROUP BY R.id
      LIMIT ($page * 10), 10
   ;
   ";
}

$result = mysql_query($query);

$json = array();
if (mysql_num_rows($result) != 0) {
   $json['status'] = 1;
   $restaurants = array();
   while ($row = mysql_fetch_assoc($result)) {
      array_push($restaurants, array('name' => $row['name'], 'image' => $row['image'], 'price' => $row['price'],
       'rating' => $row['rating'], 'numRatings' => $row['numRatings']));
   }
   $json["restaurants"] = $restaurants;
}
else {
   $json = array("status" => 0, "msg" => "No Restaurants");
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>