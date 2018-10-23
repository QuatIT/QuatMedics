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
<?php

    include 'layout/head.php';
    if($_SESSION['accessLevel']=='WARD'){
    $success = '';
    $error = '';

    $wardID = $_GET['wrdno'];

//    if(!empty($wardID)){
        $wardByID = Ward::find_by_ward_id($wardID);
        foreach($wardByID as $ward_id){}
//    }else{
        $ward = Ward::find_ward();
//    }

    if(isset($_POST['btnSave'])){
        $bedNumber = filter_input(INPUT_POST, "bedNumber", FILTER_SANITIZE_STRING);
        $bedDescription = filter_input(INPUT_POST, "bedDescription", FILTER_SANITIZE_STRING);
        $bedCharge = filter_input(INPUT_POST, "bedCharge", FILTER_SANITIZE_STRING);
        $bedStatus = "occupied";

        $bed = Ward::saveBeds($bedNumber,$bedDescription,$bedCharge,$wardID,$bedStatus);


        if($bed){
            $success = "BED CREATED SUCCESSFULLY;";
        }else{
            $error = "BED NOT CREATED";
        }

    }

    ?>

    <?php if(empty($_GET['wrdno'])){ ?>
    <div id="modal">
    <div class="modalconent text-center">
         <h4>Kindly select your Ward</h4>
        <?php foreach($ward as $wardNo){ ?>
            <a href="ward-index?wrdno=<?php echo $wardNo['wardID'] ;?>" class="btn btn-warning"><?php echo $wardNo['wardName'];?></a>
        <?php } ?>

    </div>
</div>

<?php } ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li class="active"> <a href="ward-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-plus"></i> <span>Bed Management</span></a> </li>
    <li> <a href="ward-patient?wrdno=<?php echo $wardID;?>"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index" title="" class="tip-bottom"><i class="icon-plus"></i> WARD</a>
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
                              <th>Description</th>
                              <th>Charge</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody id="load_bed"></tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Bed-info</h5>
                          </div>
                          <div class="widget-content nopadding">
<!--                            <form action="#" method="post" class="form-horizontal">-->
                             <div class="control-group">
                                <label class="control-label">Bed Number :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Bed Number" name="bedNumber" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Bed Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="bedDescription"></textarea>
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
                                <label class="control-label">Charge :</label>
                                <div class="controls">
                                  <input type="number" class="span11" placeholder="Bed Charge" name="bedCharge" required />
                                </div>
                              </div>
<!--                              <div class="controls"></div>-->
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Save Bed</button>
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


    <script>
    function load_bed(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/load_bed.php?warID=<?php echo $wardID; ?>",false);
        xmlhttp.send(null);
        document.getElementById("load_bed").innerHTML=xmlhttp.responseText;
    }
        load_bed();

        setInterval(function(){
            load_bed();
        },1000);
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
<?php }else{echo "<script>window.location='404'</script>";}?>
