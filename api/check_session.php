<?php
session_start();
$json = array('uid' => $_SESSION["uid"]);

header('Content-type: application/json');
echo json_encode($json);

?>