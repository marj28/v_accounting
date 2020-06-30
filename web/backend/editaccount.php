<?php 
require_once 'connection.php';
try {

	$accNumber = $_POST['accNumber1'];
	$accName = $_POST['accName1'];
	$accType = $_POST['accType1'];
	$accDesc = $_POST['accDesc1'];
  $sql = "UPDATE "chartofaccounts" SET
"accountnumber" = '$accNumber',
"accountname" = '$accName',
"accounttype" = '$accType',
"accountdescription" = '$accDesc'
WHERE "accNumber" = '$accNumber';";

  connect()->exec($sql);
  http_response_code(200);
  echo "Account Updated";
} catch(PDOException $e) {

  echo $sql . "<br>" . $e->getMessage();
}

 ?>