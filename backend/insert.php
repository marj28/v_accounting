<?php 
require_once 'connection.php';
try {

	$accNumber = $_POST['accNumber'];
	$accName = $_POST['accName'];
	$accType = $_POST['accType'];
	$accDesc = $_POST['accDesc'];
  $sql = "
  INSERT INTO `chartofaccounts`(`accountNumber`, `accountName`, `accountType`, `accountDescription`) 
  VALUES ('$accNumber','$accName','$accType','$accDesc')";

  connect()->exec($sql);
  http_response_code(200);
  echo "Account Inserted Successfully";
} catch(PDOException $e) {
http_response_code(500);
  echo $sql . "<br>" . $e->getMessage();
}

 ?>