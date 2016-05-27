<?php

$json = array();
$array = array();

$json["Test"] = "Hello";
array_push($array, array('name' => 'Name12'));
array_push($array, array('name' => 'Food for Us', 'loc' => '123'));
array_push($array, array('food' => 'Chinese'));
$json["Rest"] = $array;



header('Content-type: application/json');
echo json_encode($json);
?>