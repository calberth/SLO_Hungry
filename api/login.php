<?php
//Requested URL : http://localhost/SLO_Hungry/api/login.php
// Include confi.php
include_once('confi.php');

$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) :  "";
$pass = isset($_POST['pass']) ? mysql_real_escape_string($_POST['pass']) :  "";

$result = mysql_query("SELECT COUNT(*) FROM profiles WHERE email = '$email';");

if (mysql_result($result, 0) == 0) {
   $json = array("status" => 0, "msg" => "Invalid Email or Password");
}
else {
   $result = mysql_query("SELECT * FROM profiles WHERE email = '$email';");

   $row = mysql_fetch_assoc($result);
   $goodpass = $row['goodpass'];

   if (password_verify($pass, $goodpass)) {
      $json = array("status" => 1, "msg" => "Login Successful", "uId" => $row['id']);
      session_start();
      $_SESSION["uid"] = $row['id'];
   }
   else {
      $json = array("status" => 0, "msg" => "Invalid Email or Password");
   }
}

@mysql_close($conn);
 
/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>