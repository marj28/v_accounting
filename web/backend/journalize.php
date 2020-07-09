<?php
require_once 'connection.php';
try {

	$journal = $_POST['journal'];
 
  $sqlf = [];
  
foreach ($journal as  $value) {
    $journalDate = $value['journalDate'];
    $particulars = $value['particulars'];
    $dr = $value['dr'];
    $cr = $value['cr'];
    $desc = $value['desc'];

    array_push($sqlf, "('$journalDate','$particulars','$dr','$cr','$desc')");
}

$sqlf = join(",",$sqlf);

$sql = "INSERT INTO  
  journal ( transaction_date ,  account_number ,  debits ,  credits ,  description )
  VALUES ".$sqlf. ";";
   connect()->exec($sql);

  http_response_code(200);
  echo "Added Succesfully.";
} catch(PDOException $e) {
http_response_code(500);
  echo $sql . "<br>" . $e->getMessage();
}


