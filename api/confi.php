<?php
header('Access-Control-Allow-Origin: *');
$conn = mysql_connect("localhost", "root", "SLOHungry123");
mysql_select_db('slohungry', $conn);
?>