<?php
function connect(){
try {

$servername = "sql307.epizy.com";
$username = "epiz_25827053";
$password = "v1miCS2O8R9PQY";
  $conn = new PDO("mysql:host=$servername;dbname=epiz_25827053_licencing", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

return $conn;
}

print_r(connect());
?>