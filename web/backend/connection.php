<?php
function connect(){
try {


  $conn = new PDO('pgsql:host=ec2-52-72-221-20.compute-1.amazonaws.com;port=5432;dbname=ddtlhpaskt5v62', 
  	'rnvaghuuaczinn', '4988d30e4605549a95ee850a9b6e476ad15ffcd45f455caca603c09af05f53a5');
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

return $conn;
}
?>