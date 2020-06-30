<?php 
require_once 'connection.php';
try {

	$accNumber = $_POST['accNumber'];
	$accName = $_POST['accName'];
	$accType = $_POST['accType'];
	$accDesc = $_POST['accDesc'];
  $sql = "UPDATE chartofaccounts SET
accountnumber = '$accNumber',
accountname = '$accName',
accounttype = '$accType',
accountdescription = '$accDesc'
WHERE accNumber = '$accNumber';";

connect()->exec($sql);
  http_response_code(200);
  echo 'Account Updated';
} catch(PDOException $e) {

  echo $sql . "<br>" . $e->getMessage();
}

 ?>