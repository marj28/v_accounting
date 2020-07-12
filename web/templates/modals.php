<!-- The Modal -->
<div class="modal" id="addAccount">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Account</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

         <div class="form-group">
  <label for="usr">Account Number:</label>
  <input type="number" required class="form-control" onemptied="check()" oninput="check()" id="accNumber">
</div>

        <div class="form-group">
  <label for="usr">Account Name:</label>
  <input type="text" required class="form-control" onemptied="check()" oninput="check()"  id="accName">
</div>

        <div class="form-group">
  <label for="usr">Account Type:</label>
  <select id="accType" onchange="check()" required class=" form-control  custom-select">
    <option value="" disabled selected>ACCOUNT TYPE</option>
    <option value="Current Asset">Current Asset</option>
    <option value="Assets">Assets</option>
    <option value="liabilities">Liabilities</option>
    <option value="Revenue">Revenue</option>
    <option value="Expenses">Expenses</option>
    <option value="Owners Equity">Owners Equity</option>
  </select>
  
</div>


        <div class="form-group">
  <label for="usr">Account Description:</label>
  <input type="text" required class="form-control" onemptied="check()" oninput="check()" id="accDesc">
</div>
<div class="form-group">
<input type="submit" class="btn btn-primary" value="Insert" name="InsertAcc" id="InsertAcc">
</div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<?php 
require_once '../backend/connection.php';

try {
$stmt = connect()->prepare("SELECT * FROM chartofaccounts");
$stmt->execute();

$chartofaccounts = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$chartofaccounts = $stmt->fetchAll();


} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

 ?>


<!-- The Modal -->
<div class="modal" id="journalize">
  <div class="modal-document">
    <div class="modal-content">

      <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Journalize</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

      <!-- Modal body -->
<div class="modal-body">

<div class="row">
<div class="col-md-4">
  <div class="form-group">
  <label for="usr">Date</label>
  <input type="date" required class="form-control" onemptied="checkjournalInput()" oninput="checkjournalInput()"  id="journalDate">
</div>

<div class="form-group">
  <label for="usr">Account Name:</label>
  <select name="particular" id="particulars" class="custom-select" onchange="checkjournalInput()">
    <option value="" disabled selected>Select Account</option>
    <?php foreach ($chartofaccounts as $value): ?>
    <option value="<?php echo $value['accountnumber'] ?>"><?php echo $value['accountnumber']. " ".$value['accountname']  ?> </option>
    <?php endforeach ?>
  </select>
</div>

<div class="form-group">
  <label for="usr">Debit</label>
  <input type="number" required class="form-control" onemptied="checkjournalInput()" oninput="checkjournalInput()" id="dr">
</div>


        <div class="form-group">
  <label for="usr">Credit</label>
  <input type="number" required class="form-control" onemptied="checkjournalInput()" oninput="checkjournalInput()" id="cr">
</div>

  <div class="form-group">
  <label for="usr">Explanation</label>
  <input type="text" required class="form-control" onemptied="checkjournalInput()" oninput="checkjournalInput()" id="desc">
</div>
<div class="form-group">
<input type="submit" class="btn btn-primary" value="Insert" name="InsertJourn" id="InsertJourn">
<button type="button" onclick="save()" class="btn btn-primary">Save Journal</button>
</div>
</div>

<div class="col-md-8" style="max-height: 500px; overflow-y: scroll;">
  <h4 style="position: sticky;">Current Journal</h4>
  <div class="table-responsive">
   <table class="table table-striped table-sm" id="journalizing">
    <thead>
      <tr>
        <th>Transaction Date</th>
        <th>Account</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Explanation</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
</div>


</div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>




<!-- The Modal -->
<div class="modal" id="ledgerReport">
  <div class="modal-document">
    <div class="modal-content">

      <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Ledger Report</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

      <!-- Modal body -->
<div class="modal-body">

<div class="row">
<div class="col-md-2">
  <div class="form-group">
  <label for="usr">Start Date</label>
  <input type="date" required class="form-control" onemptied="checkLedgerInput()" oninput="checkLedgerInput()"  
  id="startDate">
</div>

  <div class="form-group">
  <label for="usr">End Date</label>
  <input type="date" required class="form-control" onemptied="checkLedgerInput()" oninput="checkLedgerInput()"  
  id="endDate">
</div>


<div class="form-group">
  <label for="usr">Account Name:</label>
  <select name="ledgePart" id="ledgePart" class="custom-select" onchange="checkLedgerInput()">
    <option value="" disabled selected>Select Account</option>
    <?php foreach ($chartofaccounts as $value): ?>
    <option value="<?php echo $value['accountnumber'] ?>"><?php echo $value['accountnumber']. " ".$value['accountname']  ?> </option>
    <?php endforeach ?>
  </select>
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" value="View" name="selectLedger" id="selectLedger">

</div>
</div>

<div class="col-md-10" style="max-height: 500px; overflow-y: scroll;">
  <h4 style="position: sticky;">Ledger Generated</h4>
  <div class="table-responsive">
   <table class="table table-striped table-sm" id="journalizing">
    <thead>
      <tr class="text-center">
        <th nowrap>Transaction Date</th>
        <th nowrap>Type</th>
        <th nowrap>Particulars</th>
        <th nowrap>Description</th>
        <th nowrap>Account Number</th>
        <th nowrap>Debit</th>
        <th nowrap>Credit</th>
        <th nowrap>Balance</th>
      </tr>
    </thead>
    <tbody id="ledgercontainer">


    </tbody>
  </table>
</div>
</div>


</div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="TrialBalanceModal">
  <div class="modal-document">
    <div class="modal-content">

      <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Trial Balance</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

      <!-- Modal body -->
<div class="modal-body">

<div class="row">
<div class="col-md-2">
  <div class="form-group">
  <label for="usr">Start Date</label>
  <input type="date" required class="form-control" onemptied="checkTrialBalance()" oninput="checkTrialBalance()"  
  id="trstartDate">
</div>

  <div class="form-group">
  <label for="usr">End Date</label>
  <input type="date" required class="form-control" onemptied="checkTrialBalance()" oninput="checkTrialBalance()"  
  id="trendDate">
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" value="View" name="trialBalanceMe" id="trialBalanceMe">

</div>
</div>

<div class="col-md-10" style="max-height: 500px; overflow-y: scroll;">
  <h4 style="position: sticky;">Trial Balance Generated</h4>
  <div class="table-responsive">
   <table class="table table-striped table-sm" id="journalizing">
    <thead>
      <tr class="text-center">
        <th nowrap>Transaction Date</th>
        <th nowrap>Particulars</th>
        <th nowrap>Account Number</th>
        <th nowrap>Debit</th>
        <th nowrap>Credit</th>
      </tr>
    </thead>
    <tbody id="trialBalanceContainer">


    </tbody>

<script>
  
</script>
  </table>
</div>
</div>


</div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>




<!-- The Modal -->
<div class="modal" id="incomeStatementModal">
  <div class="modal-document">
    <div class="modal-content">

      <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Balance Sheet</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

      <!-- Modal body -->
<div class="modal-body">

<div class="row">
<div class="col-md-2">
  <div class="form-group">
  <label for="usr">Start Date</label>
  <input type="date" required class="form-control" onemptied="checkIncomeStatement()" oninput="checkIncomeStatement()"  
  id="isstartDate">
</div>

  <div class="form-group">
  <label for="usr">End Date</label>
  <input type="date" required class="form-control" onemptied="checkIncomeStatement()" oninput="checkIncomeStatement()"  
  id="isendDate">
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" value="View" name="incomeStatementMe" id="incomeStatementMe">

</div>
</div>

<div class="col-md-10" style="max-height: 500px; overflow-y: scroll;">
  <h4 style="position: sticky;">Balance Sheet Generated</h4>
  <div class="table-responsive" id="incomeStatementContainer">


</div>
</div>


</div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="edtichart">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Account</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

         <div class="form-group">
  <label for="usr">Account Number:</label>
  <input type="text" required class="form-control" onemptied="checker()" oninput="checker()" id="accNumber1">
</div>

        <div class="form-group">
  <label for="usr">Account Name:</label>
  <input type="text" required class="form-control" onemptied="checker()" oninput="checker()"  id="accName1">
</div>

        <div class="form-group">
  <label for="usr">Account Type:</label>
  <select id="accType1" onchange="checker()" required class=" form-control  custom-select">
    <option value="" disabled selected>ACCOUNT TYPE</option>
    <option value="Current Asset">Current Asset</option>
    <option value="Assets">Assets</option>
    <option value="liabilities">Liabilities</option>
    <option value="Revenue">Revenue</option>
    <option value="Expenses">Expenses</option>
    <option value="Owners Equity">Owners Equity</option>
  </select>
  
</div>


        <div class="form-group">
  <label for="usr">Account Description:</label>
  <input type="text" required class="form-control" onemptied="checker()" oninput="checker()" id="accDesc1">
</div>
<div class="form-group">
<input type="submit" class="btn btn-primary" value="Insert" name="updateacc" id="updateacc">
</div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="incomestatement">
  <div class="modal-document">
    <div class="modal-content">

      <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Income Statement</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

      <!-- Modal body -->
<div class="modal-body">

<div class="row">
<div class="col-md-2">
  <div class="form-group">
  <label for="usr">Start Date</label>
  <input type="date" required class="form-control" onemptied="checkIncomeStatement1()" oninput="checkIncomeStatement1()"  
  id="isstartDate1">
</div>

  <div class="form-group">
  <label for="usr">End Date</label>
  <input type="date" required class="form-control" onemptied="checkIncomeStatement1()" oninput="checkIncomeStatement1()"  
  id="isendDate1">
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" value="View" name="incomego" id="incomego">

</div>
</div>

<div class="col-md-10" style="max-height: 500px; overflow-y: scroll;">
  <h4 style="position: sticky;">Income Statement Generated</h4>
  <div class="table-responsive" id="incomeStatementContainer1">


</div>
</div>

 

</div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
