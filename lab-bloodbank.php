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
</head>
<body>

<?php include 'layout/head.php'; ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li> <a href="lab-index.php"><i class="icon icon-warning-sign"></i> <span>Laboratory</span></a></li>
    <li class="active"> <a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Laboratory" class="tip-bottom"><i class="icon-warning-sign"></i> LABORATORY</a>
        <a title="Blood Bank" class="tip-bottom"><i class="icon-tint"></i> BLOOD BANK</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">LAB BLOOD BANK INFORMATION</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Blood Group List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Blood Group</a></li>
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
                              <th>Blood ID</th>
                              <th>Blood Type</th>
                              <th>Charge</th>
                              <th>Amount Available</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>HPS01B1</td>
                              <td>O-Positive</td>
                              <td>Ghc 200</td>
                              <td> 50 </td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01B2</td>
                              <td>A-Positive</td>
                              <td>Ghc 200</td>
                              <td> 50 </td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01B3</td>
                              <td>AB-Positive</td>
                              <td>Ghc 200</td>
                              <td> 50 </td>
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
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Blood Group</label>
                                <div class="controls">
                                  <select name="bloodGroup" class="span11" >
                                    <option value="default"> -- Blood Group --</option>
                                    <option value="O-positive">O-positive</option>
                                    <option value="O-negative">O-negative</option>
                                    <option value="A-positive">A-positive</option>
                                    <option value="A-negative">A-negative</option>
                                    <option value="B-positive">B-positive</option>
                                    <option value="B-negative">B-negative</option>
                                    <option value="AB-positive">AB-positive</option>
                                    <option value="AB-negative">AB-negative</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label"> Number Of Bags :</label>
                                <div class="controls">
                                  <input type="number" class="span11" placeholder="Number Of Bags" name="numberOfBags" />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Save Blood</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>


<!--      <hr/>-->
           <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab3">Blood Donar List</a></li>
                    <li><a data-toggle="tab" href="#tab4">Add New Blood Donar</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab3" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Donar ID</th>
                              <th>Donar Name</th>
                              <th>Blood Group</th>
                              <th>Number OF Times</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>HPS01D1</td>
                              <td> Goodman Effah</td>
                              <td>O-Positive</td>
                              <td> 50 </td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01D1</td>
                              <td> Goodman Effah</td>
                              <td>O-Positive</td>
                              <td> 50 </td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>HPS01D1</td>
                              <td> Goodman Effah</td>
                              <td>O-Positive</td>
                              <td> 50 </td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label"> Full Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Full Name" name="fullName" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Date Of Birth :</label>
                                <div class="controls">
                                  <input type="date" class="span11" placeholder="Date Of Birth" name="dob" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Group</label>
                                <div class="controls">
                                  <select name="bloodGroup">
                                    <option value="default"> -- Blood Group --</option>
                                    <option value="O-positive">O-positive</option>
                                    <option value="O-negative">O-negative</option>
                                    <option value="A-positive">A-positive</option>
                                    <option value="A-negative">A-negative</option>
                                    <option value="B-positive">B-positive</option>
                                    <option value="B-negative">B-negative</option>
                                    <option value="AB-positive">AB-positive</option>
                                    <option value="AB-negative">AB-negative</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">

                              <div class="control-group">
                                <label class="control-label">Gender</label>
                                <div class="controls">
                                  <select name="bloodGroup">
                                    <option value="default"> -- Select Gender --</option>
                                    <option value="Male"> Male </option>
                                    <option value="Female"> Female </option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Phone Number :</label>
                                <div class="controls">
                                  <input type="tel" class="span11" placeholder="Phone Number" name="phoneNumber" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Last Donate Date :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="lastDonate" />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Save Blood</button>
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
<div class="row-fluid">
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
