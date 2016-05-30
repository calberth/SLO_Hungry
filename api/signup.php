<?php
//Requested URL : http://localhost/SLO_Hungry/api/signup.php
// Include confi.php
include_once('confi.php');
header('Access-Control-Allow-Origin: *');
 
// Get data
$name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) :  "";
$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) :  "";
$goodpass = isset($_POST['pass']) ? mysql_real_escape_string($_POST['pass']) :  "";

if (!empty($name) && !empty($email) && !empty($goodpass)) {
   $result = mysql_query("SELECT COUNT(*) FROM profiles WHERE email = '$email';");

   //Email is not in database
   if (mysql_result($result, 0) == 0) {
      $options = ['cost' => 12 ];
      $goodpass = password_hash($goodpass, PASSWORD_BCRYPT, $options);
       
      // Insert data into data base
      $sql = "INSERT INTO profiles VALUES (NULL, '$name', '$email', '$goodpass');";
      $qur = mysql_query($sql);
         
      if ($qur) {
         $sql = "SELECT id FROM profiles WHERE email = '$email';";
         $result = mysql_query($sql);
         $json = array("status" => 1, "msg" => "Done User added!", 'id' => mysql_result($result, 0));
      }
      else {
         $json = array("status" => 0, "msg" => "Error adding user!");
      }
   }
   else {
      $json = array("status" => 0, "msg" => "Email already taken");
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