<?php 
require_once 'connection.php';
try {

	$accNumber = $_POST['number'];
	$accName = $_POST['accName'];
	

$stmt = connect()->prepare("SELECT COUNT(*) as totalaccs FROM chartofaccounts WHERE accountNumber = 
  '$accNumber' OR accountName = '$accName'");
$stmt->execute();
print_r($stmt);
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

if ($result[0]['totalaccs'] > 0) {

  http_response_code(403);
  echo "Account Already Exist";

}


else{
http_response_code(200);
}
 

} 

catch(PDOException $e) {
  http_response_code(500);
  echo $sql . "<br>" . $e->getMessage();
}

 ?>