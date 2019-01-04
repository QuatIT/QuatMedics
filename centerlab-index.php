<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome.css" />
<style>
.active{
    background-color: #209fbf;
}
</style>
</head>
<body>

<?php
    include 'layout/head.php';

	$centerID = $_SESSION['centerID'];
    //generate centerLabID
    $lab = new Lab;
    $centerLabIDs = $lab->find_num_Lab($centerID) + 1;

    $success = '';
    $error = '';


    if(isset($_POST['btnSave'])){


      $centerID = $_SESSION['centerID'];
      $centerLabID =  "LAB.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$centerLabIDs);
      $WardName =  filter_input(INPUT_POST, "WardName", FILTER_SANITIZE_STRING);

        $lab_sql = insert("INSERT INTO lablist(labID,labName,centerID) VALUES('$centerLabID','$WardName','$centerID') ");

        if($lab_sql){
            $success = "LAB created Successfully";
        }else{
            $error = "LAB couldn't Successfully";
        }

    }

    ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="centerlab-index.php"><i class="icon icon-search"></i> <span>Lab Management</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Lab Management" class="tip-bottom"><i class="icon-search"></i> LABORATORY</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">LAB MANAGEMENT</h3>
           <?php
                              if($success){
                              ?>
                              <div class="alert alert-success">
                          <strong>Success!</strong> <?php echo $success; ?>
                        </div>
                              <?php } if($error){
                                  ?>
                              <div class="alert alert-danger">
                          <strong>Error!</strong> <?php echo $error; ?>
                        </div>
                              <?php
                              } ?>
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">MedCenter Lab</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Lab</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Lab</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Lab ID</th>
                              <th>Lab Name</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                              $lablist = select("SELECT * FROM lablist WHERE centerID='".$_SESSION['centerID']."'");
                              if($lablist){
                                  foreach($lablist as $labrow){

                              ?>
                            <tr>
                              <td><?php echo $labrow['labID']; ?></td>
                              <td><?php echo $labrow['labName'];?></td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                              <?php }} ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Laboratory ID :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="labID" value="<?php echo $centerLabIDs; ?>" required readonly/>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Laboratory Name :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="WardName" placeholder="Lab Name" required/>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Save Laboratory</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
</div>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/maruti.js"></script>
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<script src="js/maruti.chat.js"></script>
<script src="js/maruti.form_common.js"></script>
<!--<script src="js/maruti.js"></script> -->

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();
          }
          // else, send page to designated URL
          else {
            document.location.href = newURL;
          }
      }
  }
// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
