<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
    <style>
    #modal {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99997;
    height: 100%;
    width: 100%;
}
.modalconent {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 20%;
    padding: 20px;
    z-index: 999999 !important;
}
    </style>
</head>
<body>
<?php include 'layout/head.php'; ?>

    <div id="modal">
    <div class="modalconent text-center">
         <h4>Kindly select your Ward Number</h4>
            <form action="" method="post" >
                <select class="form-control" name="wardNumber">
                    <option style="z-index:99999 !important;">--Select Ward Number--</option>
                    <option >Ward 1</option>
                    <option >Ward 2</option>
                </select>
                <br>
                <br>
                <p class="text-center"><input type="submit" name="btnSend" class="btn btn-primary"> <button class="btn btn-light" id="button">Close</button></p>
        </form>


    </div>
</div>



<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="ward-index.php"><i class="icon icon-plus"></i> <span>Bed Management</span></a> </li>
    <li> <a href="ward-patient.php"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index.php" title="" class="tip-bottom"><i class="icon-plus"></i> WARD</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">WARD MANAGEMENT</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Bed List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Bed</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Bed Number</th>
                              <th>Bed Type</th>
                              <th>Charge</th>
                              <th>Description</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>HPS01W2B4</td>
                              <td>Bed Type</td>
                              <td>Ghc 200</td>
                              <td>A comfortable Bed :)</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01W2B5</td>
                              <td>Bed Type</td>
                              <td>Ghc 500</td>
                              <td>A comfortable Bed :)</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01W2B6</td>
                              <td>Bed Type</td>
                              <td>Ghc 400</td>
                              <td>A comfortable Bed :)</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Bed-info</h5>
                          </div>
                          <div class="widget-content nopadding">
<!--                            <form action="#" method="post" class="form-horizontal">-->
                               <div class="control-group">
                                <label class="control-label">Bed Category</label>
                                <div class="controls">
                                  <select name="bedCategory" >
                                    <option value="default"> -- Bed Category --</option>
                                    <option value="categoryName"> Category Name</option>
                                    <option value="categoryName"> Category Name</option>
                                    <option value="categoryName"> Category Name</option>
                                  </select>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Bed Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="bedDesciption"></textarea>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Bed-info</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Bed Number :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Bed Number" name="bedNumber" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Charge :</label>
                                <div class="controls">
                                  <input type="number" class="span11" placeholder="Bed Charge" name="bedCharge" required />
                                </div>
                                  <br/>
                              </div>
<!--                              <div class="controls"></div>-->
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Save Bed</button>
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
<div class="row-fluid navbar-fixed-bottom">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
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



<script>
window.onload = function () {
    document.getElementById('button').onclick = function () {
        document.getElementById('modal').style.display = "none"
    };
};
</script>

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
