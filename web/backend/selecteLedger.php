<?php
require_once 'connection.php';

$accNumber = $_GET['number'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
try {
$stmt = connect()->prepare("SELECT journal.transaction_date, journal.debits, journal.credits,
	chartofaccounts.accountnumber, chartofaccounts.accountname, chartofaccounts.accounttype, chartofaccounts.accountdescription FROM chartofaccounts, journal WHERE journal.account_number::varchar = chartofaccounts.accountnumber AND accountnumber = '$accNumber' AND transaction_date >= '$startDate' AND transaction_date <= 
	'$endDate'");
$stmt->execute();
print_r($stmt);
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

print_r($result);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$balance = 0.00;
?>

<?php foreach ($result as  $value): ?>
	<?php $balance = $balance + ($value['debits'] - $value['credits']); ?>
	<tr class="text-center">
		<td nowrap><?php echo $value['transaction_date']; ?></td>
		<td nowrap><?php echo $value['accounttype']; ?></td>
		<td nowrap><?php echo $value['accountname']; ?></td>
		<td nowrap><?php echo $value['accountnumber']; ?></td>
		<td nowrap><?php echo $value['accountdescription']; ?></td>
		<td nowrap><?php echo $value['debits']; ?></td>
		<td nowrap><?php echo $value['credits']; ?></td>
		<td nowrap><?php echo $balance; ?></td>
	</tr>
<?php endforeach ?>