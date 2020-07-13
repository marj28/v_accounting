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
WHERE accountnumber = '$accNumber'  OR accountname = '$accName';;";

connect()->exec($sql);
  http_response_code(200);
  echo 'Updated Successfully. Please reload to view the changes';
} catch(PDOException $e) {

  echo $sql . "<br>" . $e->getMessage();
}

 ?>