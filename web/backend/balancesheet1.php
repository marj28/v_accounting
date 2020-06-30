<?php 
require_once 'connection.php';
$accounts = array('Current Asset','Assets','liabilities','Revenue','Expenses','Owners Equity');
$balancesheet = [];


function balancing($accounts,$startDate,$endDate){

	try {
		$tbodyassets = "";
		$totalfinal=0;
		$totalliabilities =0;
		$tbodylia = "";
		$totalequity = 0;
		$tbodyequity = "";
		$income = 0;
		foreach ($accounts as  $value) {

			$stmt = connect()->prepare("SELECT DISTINCT chartofaccounts.accountname,journal.account_number FROM chartofaccounts, journal WHERE chartofaccounts.accountType = '$value' AND transaction_date >= '$startDate' AND transaction_date <= '$endDate' AND chartofaccounts.accountnumber = journal.account_number::varchar");

			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result = $stmt->fetchAll();

			foreach ($result as  $resacc) {
				$accNumber = $resacc['account_number'];
				$stmt = connect()->prepare("SELECT SUM(debits) as totaldebits FROM journal WHERE account_number = '$accNumber' AND transaction_date >= '$startDate' AND transaction_date <= '$endDate'");
				$stmt->execute();
				$debitstotal = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				$debitstotal = $stmt->fetchAll();

				$stmt = connect()->prepare("SELECT SUM(credits) as totalcredits FROM journal WHERE account_number = '$accNumber' AND transaction_date >= '$startDate' AND transaction_date <= '$endDate'");

				$stmt->execute();
				$creditstotal = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				$creditstotal = $stmt->fetchAll();

				if ($value == 'Current Asset' || $value == 'Assets') {
				$total = $debitstotal[0]['totaldebits'] - $creditstotal[0]['totalcredits'];
				$totalfinal += $total;
				$tbodyassets .= "<tr><th>".$resacc['accountname']."</th><th>".$total."</th></tr>";
				}

				if ($value == 'liabilities' || $value == 'Liabilities') {
					$total = $creditstotal[0]['totalcredits'] - $debitstotal[0]['totaldebits'];
					$totalliabilities += $total;
					$tbodylia .= "<tr><th>".$resacc['accountname']."</th><th>".$total."</th></tr>";
				}


				if ($value == 'Owners Equity') {

					if (preg_match("/\bdepreciation\b/i", $resacc['accountname'])) {

						$total = $creditstotal[0]['totalcredits'] - $debitstotal[0]['totaldebits'];
						$totalequity += $total;
						$tbodyequity .= "<tr><th>".$resacc['accountname']."</th><th>".$total."</th></tr>";
					}

					if (preg_match("/Capital/i", $resacc['accountname'])) {
						$total = $creditstotal[0]['totalcredits'] - $debitstotal[0]['totaldebits'] + 
						$income = netincome($startDate,$endDate);
						$totalequity += $total;
						$tbodyequity .= "<tr><th>".$resacc['accountname']."</th><th>".$total."</th></tr>";
					}

					else{
						$total = $debitstotal[0]['totaldebits'] - $creditstotal[0]['totalcredits'];
						$totalequity += $total;
						$tbodyequity .= "<tr><th>".$resacc['accountname']."</th><th>".$total."</th></tr>";
					}

				}


				
				
			}


		}

		$result = "<table class='table table-striped table-sm'>
		<h1>Assets</h1>
					<thead>
						".$tbodyassets."

						<tr style='border-top:double;'>
						<th>Total Assets: </th>
						<th>".$totalfinal."</th>
						</tr>
					</thead>

					</table>";

		$result .= "<table class='table table-striped table-sm'>
		<h1>Liabilities</h1>
					<thead>
						".$tbodylia."

						<tr style='border-top:double;'>
						<th>Total Liabilities: </th>
						<th>".$totalliabilities."</th>
						</tr>
					</thead>

					</table>";

		$result .= "<table class='table table-striped table-sm'>
		<h1>Owner's Equity</h1>
					<thead>
						".$tbodyequity."

						<tr style='border-top:double;'>
						<th>Total Owners Equity: </th>
						<th>".$totalequity."</th>
						</tr>
						<tr style='border-top:double;'>
						<th>Total Owners Equity and Liablites</th>
						<th>".(($totalliabilities + $totalequity) + $income)."</th>
						</tr>
					</thead>

					</table>";
		print_r($income);
		return $result;
	}


	 catch (Exception $e) {
		
	}
	

}

function netincome($startDate,$endDate){
	try {
		
		$netincome = 0;$gross = 0; $expense = 0;	
		$stmt  = $stmt = connect()->prepare("SELECT  journal.debits, journal.credits FROM chartofaccounts, journal WHERE chartofaccounts.accountType = 'Revenue' AND transaction_date >= '$startDate' AND transaction_date <= '$endDate' AND chartofaccounts.accountnumber = journal.account_number");

		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$result = $stmt->fetchAll();

		foreach ($result as  $value) {
			$gross = $gross + ($value['credits'] - $value['debits'])	;
		}


		$stmt  = $stmt = connect()->prepare("SELECT  journal.debits, journal.credits FROM chartofaccounts, journal WHERE chartofaccounts.accountType = 'Expenses' AND transaction_date >= '$startDate' AND transaction_date <= '$endDate' AND chartofaccounts.accountnumber = journal.account_number");

		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$result = $stmt->fetchAll();

		foreach ($result as  $value) {
			$expense = $expense + ($value['credits'] - $value['debits'])	;
		}

		$netincome = $gross - $expense;
		echo "<script>alert('".$netincome."')</script>";
		return $netincome;
	} 

	catch (PDOException $e) {
		return $e;
	}
}



?>


<?php print_r(balancing($accounts,$_GET['startDate'],$_GET['endDate'])); ?>
