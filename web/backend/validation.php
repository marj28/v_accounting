<?php 
require_once 'connection.php';

$accNumber = $_GET['number'];
$accName = $_GET['accName'];
try {
$stmt = connect()->prepare("SELECT COUNT(*) as TotalCount FROM chartofaccounts WHERE `accountNumber` = '$accNumber' OR `accountName` = '$accName'");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

if ($result[0]['TotalCount'] > 0) {
	http_response_code(403);
	echo False;
}
else{
	http_response_code(200);
	echo True;
}
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

 ?>