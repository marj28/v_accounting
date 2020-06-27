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
<div class="modal-body" >
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
  <input type="text" required class="form-control" onemptied="check()" oninput="check()" id="accType">
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
