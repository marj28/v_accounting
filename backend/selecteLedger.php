<?php
require_once 'connection.php';

$accNumber = $_GET['number'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
try {
$stmt = connect()->prepare("SELECT `journal`.`transaction_date`, `journal`.`debits`, `journal`.`credits`,
	`chartofaccounts`.`accountNumber`, `chartofaccounts`.`accountName`, `chartofaccounts`.`accountType`, `chartofaccounts`.`accountDescription` FROM `chartofaccounts`, `journal` WHERE `journal`.`account_number` = `chartofaccounts`.`accountNumber` AND `accountNumber` = '$accNumber' AND `transaction_date` >= '$startDate' AND `transaction_date` <= 
	'$endDate'");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();


} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$balance = 0.00;
?>

<?php foreach ($result as  $value): ?>
	<?php $balance = $balance + ($value['debits'] - $value['credits']); ?>
	<tr class="text-center">
		<td nowrap><?php echo $value['transaction_date']; ?></td>
		<td nowrap><?php echo $value['accountType']; ?></td>
		<td nowrap><?php echo $value['accountName']; ?></td>
		<td nowrap><?php echo $value['accountNumber']; ?></td>
		<td nowrap><?php echo $value['accountDescription']; ?></td>
		<td nowrap><?php echo $value['debits']; ?></td>
		<td nowrap><?php echo $value['credits']; ?></td>
		<td nowrap><?php echo $balance; ?></td>
	</tr>
<?php endforeach ?>