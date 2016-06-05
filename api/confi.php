<?php
header('Access-Control-Allow-Origin: *');
$conn = mysql_connect("localhost", "root", "");
mysql_select_db('slohungry', $conn);
?>