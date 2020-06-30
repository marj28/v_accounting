<?php 
require_once 'connection.php';
try {

	$accNumber = $_GET['number'];
	$for = $_GET['for'];
  	$sql = "DELETE FROM chartofaccounts WHERE accountNumber = '$accNumber'";

  connect()->exec($sql);
  http_response_code(200);
  echo 'Deleted';
} catch(PDOException $e) {
http_response_code(500);
  echo $sql . "<br>" . $e->getMessage();
}