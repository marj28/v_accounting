<?php
require_once 'connection.php';
try {

	$journalDate = $_POST['journalDate'];
	$particulars = $_POST['particulars'];
	$dr = $_POST['dr'];
	$cr = $_POST['cr'];
	$desc = $_POST['desc'];
  $sql = "
  INSERT INTO `journal`(`transaction_date`, `account_number`, `debits`, `credits`, `description`)
  VALUES ('$journalDate','$particulars','$dr','$cr','$desc')";

  connect()->exec($sql);
  http_response_code(200);
} catch(PDOException $e) {
http_response_code(500);
  echo $sql . "<br>" . $e->getMessage();
}



class Classroom {
  
 private $oldLaw = False;

 function changeLaw($newLaw){
  
  if ($newLaw === $this.oldLaw) {
    changeLaw($canGoOut=True);
  }

  else{
    goOut();
  }

  }

}
