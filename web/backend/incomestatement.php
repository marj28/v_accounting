<?php
require_once 'connection.php';

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
try {
$stmt = connect()->prepare("
	SELECT 
		journal.transaction_date, 
		journal.debits, 
		journal.credits,
		chartofaccounts.accountNumber, 
		chartofaccounts.accountName 
	FROM 
		chartofaccounts, 
		journal 
	WHERE 
		journal.account_number::varchar = chartofaccounts.accountNumber 
	AND 
		chartofaccounts.accounttype =  'Revenue' 
	AND 
		transaction_date >= '$startDate' 
	AND 
		transaction_date <= '$endDate'");

$stmt->execute();
$income = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$income = $stmt->fetchAll();


$stmt = connect()->prepare("
	SELECT 
		journal.transaction_date, 
		journal.debits, 
		journal.credits,
		chartofaccounts.accountNumber, 
		chartofaccounts.accountName 
	FROM 
		chartofaccounts, 
		journal 
	WHERE 
		journal.account_number::varchar = chartofaccounts.accountNumber 
	AND 
		chartofaccounts.accounttype =  'Expenses' 
	AND 
		transaction_date >= '$startDate' 
	AND 
		transaction_date <= '$endDate'");

$stmt->execute();
$expenses = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$expenses = $stmt->fetchAll();


} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<?php $incomecr = 0.00; $expensedr = 0.00; ?>
	<tr>
		<td><h3><b>Income</b></h3></td>
		<td><?php print_r($_GET) ?></td>
		<td></td>
	</tr>
<?php foreach ($income as  $value): ?>
<?php $incomecr = $incomecr + ($value['credits'] - $value['debits']); ?>

	<tr class="text-center">
		<td nowrap>Account: </td>
		<td nowrap><?php echo $value['accountname']; ?></td>
		<td nowrap></td>
	</tr>

	<tr class="text-center">
		<td nowrap>Transaction Date: </td>
		<td nowrap><?php echo $value['transaction_date']; ?></td>
		<td nowrap></td>
	</tr>

		<tr class="text-center">
		<td nowrap>Amount:</td>
		<td nowrap></td>
		<td nowrap><?php echo $value['credits']; ?></td>
	</tr>
<?php endforeach ?>
	<tr class="text-center">
		<td>Gross Income:</td>
		<td></td>
		<td><?php echo $incomecr; ?></td>
	</tr>

	<tr>
		<td><h3><b>Expense</b></h3></td>
		<td></td>
		<td></td>
	</tr>

	<?php foreach ($expenses as $value): ?>

		<?php $expensedr = $expensedr + ($value['debits'] - $value['credits']); ?>

	<tr class="text-center">
		<td nowrap>Account: </td>
		<td nowrap><?php echo $value['accountname']; ?></td>
		<td nowrap></td>
	</tr>


	<tr class="text-center">
		<td nowrap>Transaction Date: </td>
		<td nowrap><?php echo $value['transaction_date']; ?></td>
		<td nowrap></td>
	</tr>

		<tr class="text-center">
		<td nowrap>Amount:</td>
		<td nowrap></td>
		<td nowrap><?php if ($value['credits'] > 0): ?>
			(<?php echo $value['credits']; ?>)
			<?php else: ?>
				<?php echo $value['debits']; ?>
		<?php endif ?></td>
	</tr>

	<?php endforeach ?>

	<tr class="text-center">
		<td>Total Expenses:</td>
		<td></td>
		<td><?php echo $expensedr; ?></td>
	</tr>

	<tr class="text-center">
		<td>Net Income:</td>
		<td></td>
		<td><?php echo $incomecr - $expensedr; ?></td>
	</tr