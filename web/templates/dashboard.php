<?php require_once '../backend/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once 'header.php'; ?>
  <title>Home</title>
</head>
<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          V
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          LAUNDRY
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="index.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#addAccount">
              <i class="now-ui-icons education_atom"></i>
              <p>Add Account</p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#journalize">
              <i class="now-ui-icons location_map-big"></i>
              <p>Journalize</p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#ledgerReport">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Ledger Report</p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#TrialBalanceModal">
              <i class="now-ui-icons users_single-02"></i>
              <p>Trial Balance</p>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#incomeStatementModal">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Balance Sheet</p>
            </a>
          </li>

            <li>
            <a href="javascript:void(0)" id="hatdog"  data-toggle="modal" data-target="#incomestatement">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Income Statement</p>
            </a>
          </li>
        
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header ">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-category">V Laundry</h5>
                <h4 class="card-title">Chart of Accounts</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="chartofaccountstable">
                    <thead class=" text-primary">
                      <th nowrap>
                        Account Number
                      </th>
                      <th nowrap>
                        Account Name
                      </th>
                      <th nowrap>
                        Account Type
                      </th>
                      <th nowrap class="text-right">
                        Account Description
                      </th>

                      <th nowrap class="text-center">
                        Action
                      </th>
                    </thead>
                    <tbody>
<?php 
$stmt = connect()->prepare("SELECT *  FROM chartofaccounts");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll(); 
?>
                      <?php foreach ($result as $value): ?>
                      <tr id="chart<?php echo $value['accountnumber'] ?>">
                        <td nowrap>
                          <?php echo $value['accountnumber'] ?>
                        </td>
                        <td nowrap>
                          <?php echo $value['accountname'] ?>
                        </td>
                        <td nowrap>
                          <?php echo $value['accounttype'] ?>
                        </td nowrap>
                        <td class="text-right" nowrap>
                          <?php echo $value['accountdescription'] ?>
                        </td>
                        <td class="text-center">
                          <button class="btn btn-danger btn-sm" 
                          onclick="deleteAccount('<?php echo $value['accountnumber'] ?>')">Delete</button>

                          <button class="btn btn-sucess btn-sm" data-toggle="modal" data-target="#edtichart"

                          onclick="editchart(
                            <?php echo $value['accountnumber'] ?>,
                            '<?php echo $value['accountname'] ?>',
                            '<?php echo $value['accounttype'] ?>',
                            '<?php echo $value['accountdescription'] ?>')">Edit</button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../static/assets/js/core/jquery.min.js"></script>
  <script src="../static/assets/js/core/popper.min.js"></script>
  <script src="../static/assets/js/core/bootstrap.min.js"></script>
  <script src="../static/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../static/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../static/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../static/assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../static/assets/demo/demo.js"></script>
  <script type="../static/backend/main.js"></script>

</body>
<?php require_once 'modals.php'; ?>
</html>