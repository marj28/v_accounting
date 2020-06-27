<?php 
require_once 'connection.php';

// $startDate = $_GET['startDate'];
// $endDate = $_GET['endDate'];
$startDate = '2014-09-01';
$endDate = '2015-09-01';
$iterator = 0;
$totalAssets = 0;
try {

$netincome = 0;$gross = 0; $expense = 0;	

$stmt  = $stmt = connect()->prepare("SELECT  `journal`.`debits`, `journal`.`credits` FROM `chartofaccounts`, `journal` WHERE `chartofaccounts`.`accountType` = 'Revenue' AND `transaction_date` >= '$startDate' AND `transaction_date` <= '$endDate' AND `chartofaccounts`.`accountNumber` = `journal`.`account_number`");

$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();


foreach ($result as  $value) {
	$gross = $gross + ($value['credits'] - $value['debits'])	;
}


$stmt  = $stmt = connect()->prepare("SELECT  `journal`.`debits`, `journal`.`credits` FROM `chartofaccounts`, `journal` WHERE `chartofaccounts`.`accountType` = 'Expenses' AND `transaction_date` >= '$startDate' AND `transaction_date` <= '$endDate' AND `chartofaccounts`.`accountNumber` = `journal`.`account_number`");

$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

foreach ($result as  $value) {
	$expense = $expense + ($value['credits'] - $value['debits'])	;
}

$netincome = $gross - $expense;
print_r($netincome);

$accounts = array('Current Asset','Assets','liabilities','Revenue','Expenses','Owners Equity');
?>


<?php
foreach ($accounts as  $value) {
	// $value = str_replace(" ","-",$value);
	// echo $value;

$stmt = connect()->prepare("SELECT DISTINCT `chartofaccounts`.`accountName`,`journal`.`account_number` FROM `chartofaccounts`, `journal` WHERE `chartofaccounts`.`accountType` = '$value' AND `transaction_date` >= '$startDate' AND `transaction_date` <= '$endDate' AND `chartofaccounts`.`accountNumber` = `journal`.`account_number`");

$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();


foreach ($result as  $resacc) {
	$accNumber = $resacc['account_number'];
	$stmt = connect()->prepare("SELECT SUM(debits) as 'totalDebits' FROM journal WHERE `account_number` = '$accNumber'");

	$stmt->execute();
	$debitstotal = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	$debitstotal = $stmt->fetchAll();

	$stmt = connect()->prepare("SELECT SUM(credits) as 'totalcredits' FROM journal WHERE `account_number` = '$accNumber'");

	$stmt->execute();
	$creditstotal = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	$creditstotal = $stmt->fetchAll();
	

?>
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../static/assets/css/bootstrap.min.css">
	</head>
	<body>
	<table class="table table-striped">
<?php if ($value == 'Current Asset' || $value == 'Assets'): ?>
	
	<?php 
	$totalAssets += $debitstotal[0]['totalDebits'] - $creditstotal[0]['totalcredits'];
	 ?>
	<?php if ($iterator === 0): 
		$iterator++;?>
	
		<thead>
			<tr>
				<th>Assets</th>
			</tr>
		</thead>
	<?php endif ?>
		
			<tbody>
			<tr >
				<td><?php print_r($resacc['accountName']); ?> : <?php print_r($debitstotal[0]['totalDebits']- $creditstotal[0]['totalcredits']); ?></td>
				
			</tr>
		</tbody>
	</table>


<?php endif ?>

<?php 
}

}

 ?>
<?php } 

catch (PDOException $e) {
	
} ?>
	</body>
	</html>
