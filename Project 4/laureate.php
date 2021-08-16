<?php
// get the id parameter from the request
header('Content-Type: application/json');
$id = intval($_GET['id']);
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$filter = [ 'id' => strval($id) ];
$options = [ 'projection' => ['_id' => 0]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery("nobel.laureates",$query);
$output = current($rows->toArray());

echo json_encode($output, JSON_PRETTY_PRINT);

?>
