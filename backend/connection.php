<?php
function connect(){
try {

$servername = "localhost";
$username = "root";
$password = "";
  $conn = new PDO("mysql:host=$servername;dbname=curay_laundry", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

return $conn;
}
?>