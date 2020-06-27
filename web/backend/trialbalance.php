<?php
require_once 'connection.php';

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
try {
$stmt = connect()->prepare("SELECT journal.transaction_date, journal.debits, journal.credits,chartofaccounts.accountnumber, chartofaccounts.accountname FROM chartofaccounts, journal WHERE journal.account_number::varchar = chartofaccounts.accountnumber AND transaction_date >= '$startDate' AND transaction_date <= '$endDate'");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();


} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<?php $totalDebit = 0.00; $totalCredit = 0.00; ?>
<?php foreach ($result as  $value): ?>
	<?php $totalDebit = $totalDebit + $value['debits']; ?>
	<?php $totalCredit = $totalCredit + $value['credits']; ?>
	<tr class="text-center">
		<td nowrap><?php echo $value['transaction_date']; ?></td>
		<td nowrap><?php echo $value['accountname']; ?></td>
		<td nowrap><?php echo $value['accountnumber']; ?></td>
		<td nowrap><?php echo $value['debits']; ?></td>
		<td nowrap><?php echo $value['credits']; ?></td>
	</tr>
<?php endforeach ?>
	<tr class="text-center">
		<td><b>Total: </b></td>
		<td></td>
		<td></td>
		<td><?php echo $totalDebit ?></td>
		<td><?php echo $totalCredit ?></td>
	</tr>