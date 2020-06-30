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
  <input type="text" required class="form-control" onemptied="check()" oninput="check()" id="accNumber">
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

<script>
  
  $(document).ready(function() {
      $("#InsertAcc").attr("disabled", "disabled");
      $("#InsertJourn").attr("disabled", "disabled");
      $("#selectLedger").attr("disabled", "disabled");
      $("#updateacc").attr("disabled", "disabled");
  });

  function check() {
    var accNumber = $("#accNumber").val();
    var accName = $("#accName").val();
    var accType = $("#accType").val();
    var accDesc = $("#accDesc").val();
    if (accName != "" && accNumber != "" && accDesc != "" && accType != "") {
      $("#InsertAcc").removeAttr("disabled");
    }
    else{
      $("#InsertAcc").attr("disabled", "disabled");
    }
  }

$("#InsertAcc").click(function(e){
  e.stopPropagation();
  var accNumber = $("#accNumber").val();
  var accName = $("#accName").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var response = this.responseText;
      
      if (this.status == 200) {
        chartAjax();
      }
    }

    if (this.status == 403) {
      alert("Account Already Exist");
    }
    
  };
  xhttp.open("GET", "../backend/validation.php?number="+accNumber+"&accName="+accName, true);
  xhttp.send();
});

function chartAjax(){
    var accNumber = $("#accNumber").val();
    var accName = $("#accName").val();
    var accType = $("#accType").val();
    var accDesc = $("#accDesc").val();
  $.ajax({
    url: '../backend/insert.php',
    type: 'POST',
    data: {accNumber: accNumber,accName: accName,accType: accType,accDesc: accDesc},
  })
  .done(function(data) {
    console.log(data);
    var newRowContent = `<tr id="chart${accNumber}">
    <td>${accNumber}</td><td>${accName}</td><td>${accType}</td>
    <td class="text-right">${accDesc}</td>
    <td class="text-center">
    <button class="btn btn-danger" 
    onclick="deleteAccount(${accNumber})">Delete
    </button>
    <button class="btn btn-success" 
    onclick="edit(${accNumber})">Edit
    </button>
    </td>
    </tr>`;
    $('#chartofaccountstable > tbody:last').append(newRowContent);
    alert(data);
   $("#accNumber").val('');
   $("#accName").val('');
    $("#accType").val('');
   $("#accDesc").val('');
   $("#InsertAcc").attr("disabled", "disabled");
  })
  .fail(function(data) {
    console.log(data);
    alert("Error, Please check the console for more details");
  })
  .always(function() {
    console.log("complete");
  });
  
}
</script>

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


<script>
  
function checkjournalInput(){
  var journalDate = $("#journalDate").val();
  var particulars = $("#particulars").val();
  var dr = $("#dr").val();
  var cr = $("#cr").val();
  var desc = $("#desc").val();

if (journalDate && desc  && cr  && dr  && particulars ) {
      $("#InsertJourn").removeAttr("disabled");
    }
    else{
      $("#InsertJourn").attr("disabled", "disabled");
    }
}

$("#InsertJourn").click(function(e){
  e.stopPropagation();
  var journalDate = $("#journalDate").val();
  var particulars = $("#particulars").val();
  var dr = $("#dr").val();
  var cr = $("#cr").val();
  var desc = $("#desc").val();
  $.ajax({
    url: '../backend/journalize.php',
    type: 'POST',
    data: {journalDate: journalDate,particulars: particulars,dr: dr,cr: cr,desc: desc},
  })
  .done(function(data) {
    console.log("success");

    var newRowContent = `<tr id="journalize${accNumber}">
    <td>${journalDate}</td><td>${particulars}</td><td>${dr}</td>
    <td>${cr}</td><td>${desc}</td>
    </tr>`;
    $('#journalizing > tbody:last').append(newRowContent);
   $("#journalDate").val('');
   $("#particulars").val('');
    $("#dr").val('');
   $("#cr").val('');
   $("#desc").val('');
   $("#InsertJourn").attr("disabled", "disabled");
  })
  .fail(function(data) {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
});

</script>


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

    <script>
  function checkLedgerInput() {
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    var ledgePart = $("#ledgePart").val();

    if (ledgePart && startDate && endDate) {
      $("#selectLedger").removeAttr("disabled");
    }
    else{
      $("#selectLedger").attr("disabled", "disabled");
    }
  }


  $("#selectLedger").click(function(e){
    e.stopPropagation();

  var startDate = $("#startDate").val();
  var endDate = $("#endDate").val();
  var ledgePart = $("#ledgePart").val();
    $.ajax({
      url: '../backend/selecteLedger.php',
      type: 'GET',
      data: {number: ledgePart,startDate: startDate,endDate: endDate},
    })
    .done(function(data) {
      $("#ledgercontainer").html(data);
      console.log(data);
    })
    .fail(function(data) {
      console.log(data);
    })
    .always(function(data) {
      console.log(data);
    });
    


  // var xhttp = new XMLHttpRequest();
  // xhttp.onreadystatechange = function() {
  //   if (this.readyState == 4 && this.status == 200) {
  //     var response = this.responseText;
      
  //         }
  // };
  // xhttp.open("GET", "../backend/selecteLedger.php?number="+ledgePart+"&startDate="+startDate+"&endDate="+endDate, true);
  // xhttp.send();
});

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
  function checkTrialBalance() {
    var startDate = $("#trstartDate").val();
    var endDate = $("#trendDate").val();


    if (startDate && endDate) {
      $("#trialBalanceMe").removeAttr("disabled");
    }
    else{
      $("#trialBalanceMe").attr("disabled", "disabled");
    }
  }


  $("#trialBalanceMe").click(function(e){
  e.stopPropagation();
  var startDate = $("#trstartDate").val();
  var endDate = $("#trendDate").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var response = this.responseText;
    $("#trialBalanceContainer").html(response);
    }
  };
  xhttp.open("GET", "../backend/trialbalance.php?startDate="+startDate+"&endDate="+endDate, true);
  xhttp.send();
});

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

<script>
  function checkIncomeStatement() {
    var startDate = $("#isstartDate").val();
    var endDate = $("#isendDate").val();


    if (startDate && endDate) {
      $("#incomeStatementMe").removeAttr("disabled");
    }
    else{
      $("#incomeStatementMe").attr("disabled", "disabled");
    }
  }

  $("#incomeStatementMe").click(function(e){
  e.stopPropagation();
  var startDate = $("#isstartDate").val();
  var endDate = $("#isendDate").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var response = this.responseText;
    $("#incomeStatementContainer").html(response);
    }
  };
  xhttp.open("GET", "../backend/balancesheet1.php?startDate="+startDate+"&endDate="+endDate, true);
  xhttp.send();
});

</script>
 
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

<script>

  function checker() {
    var accNumber = $("#accNumber1").val();
    var accName = $("#accName1").val();
    var accType = $("#accType1").val();
    var accDesc = $("#accDesc1").val();
    if (accName != "" && accNumber != "" && accDesc != "" && accType != "") {
      $("#updateacc").removeAttr("disabled");
    }
    else{
      $("#updateacc").attr("disabled", "disabled");
    }
  }


  $("#updateacc").click(function(e){
  e.stopPropagation();
  var accNumber = $("#accNumber1").val();
  var accName = $("#accName1").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var response = this.responseText;
      
      if (this.status == 200) {
        editaccount();
      }
    }

    if (this.status == 403) {
      alert("Account Already Exist");
    }
    
  };
  xhttp.open("GET", "../backend/validation.php?number="+accNumber+"&accName="+accName, true);
  xhttp.send();
});


function editaccount(){
    var accNumber = $("#accNumber1").val();
    var accName = $("#accName1").val();
    var accType = $("#accType1").val();
    var accDesc = $("#accDesc1").val();
  $.ajax({
    url: '../backend/editaccount.php',
    type: 'POST',
    data: {accNumber: accNumber,accName: accName,accType: accType,accDesc: accDesc},
  })
  .done(function(data) {
    console.log(data);
   $("#accNumber1").val('');
   $("#accName1").val('');
    $("#accType1").val('');
   $("#accDesc1").val('');
   $("#updateacc").attr("disabled", "disabled");
  })
  .fail(function(data) {
    console.log(data);
    alert("Error, Please check the console for more details");
  })
  .always(function() {
    console.log("complete");
  });
  
}  


</script>