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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <style>
        .active{
            background-color: #209fbf;
        }
            label{
                font-weight: bolder;
            }
    </style>
  <style type="text/css">
        .center {
    margin-top:50px;
}

.modal-header {
	padding-bottom: 5px;
}

.modal-footer {
    	padding: 0;
	}

.modal-footer .btn-group button {
	height:40px;
	border-top-left-radius : 0;
	border-top-right-radius : 0;
	border: none;
	border-right: 1px solid #ddd;
}

.modal-footer .btn-group:last-child > button {
	border-right: 0;
}
    </style>

</head>
<body>


<?php
    include 'layout/head.php';

    #if($_SESSION['accessLevel']=='OPD' || $_SESSION['username']=='rik'){

    $active2='';
    $active3='';
    $active='';
    $success = '';
    $error = '';

    $tab = $_GET['tab'];

    if($tab == "admed"){
        $active2 = "active";
//        $patient = select("SELECT * FROM emergency_patient WHERE patientID='".$_GET['pid']."' ORDER BY patientID ASC");
//        foreach($patient as $pID){}



    }elseif($tab == "tab1"){
        $active  = "active";
    }elseif($tab == "srequests"){
        $active3  = "active";
    }


	$reqIDs = count(select("SELECT * FROM dispensary_tb")) + 1;

    if(isset($_POST['btnSave'])){


      $reqID = "REQ.MED.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$reqIDs);
//      $staffID = $staffID['userID'];
		$reqm = select("SELECT * FROM pharmacy_inventory");
		foreach($reqm as $rem){}

		$medname = $rem['medicine_name'];

      $medicine_id = filter_input(INPUT_POST, "medicine_name", FILTER_SANITIZE_STRING);
      $no_of_piece = filter_input(INPUT_POST, "no_of_piece", FILTER_SANITIZE_STRING);

		$request_status = 'pending';
		$centerID = $_SESSION['centerID'];
		$requested_by = $_SESSION['username'];

		$store = insert("INSERT INTO dispensary_tb_history(request_id,medicine_id,medicine_name,no_of_piece,requested_by,centerID,request_status,date_requested) VALUES('$reqID','$medicine_id','$medname','$no_of_piece','$requested_by','$centerID','$request_status',CURDATE() ) ");

		$sqlx = select("SELECT * FROM dispensary_tb");
		foreach($sqlx as $rowx){}

		if(count($rowx['medicine_id']) >= 1){

		$storex = update("UPDATE dispensary_tb SET request_id='$reqID',medicine_name='$medname',no_of_piece='$no_of_piece',requested_by='$requested_by',centerID='$centerID',request_status='$request_status',date_requested=CURDATE() WHERE medicine_id='$medicine_id' ");
		}else{

		$storexx = insert("INSERT INTO dispensary_tb(request_id,medicine_id,medicine_name,no_of_piece,requested_by,centerID,request_status,date_requested) VALUES('$reqID','$medicine_id','$medname','$no_of_piece','$requested_by','$centerID','$request_status',CURDATE() ) ");

		}

		if($store){
            $success = $medname." request sent";
        }else{
            $error = "Request failed";
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
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    <li class="active"><a href="dispensary"> <span>Dispensary</span></a></li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Out Patient Department" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="Old Patients" class="tip-bottom"><i class="icon-user"></i> OPD OLD PATIENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">DISPENSARY</h3>
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
<!--                    <li class="<?php #echo $active; ?>"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>-->

                    <li class="<?php echo $active2; ?>"><a data-toggle="tab" href="#tab2">Request Medicine </a></li>
                    <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#tab1">Stock List</a></li>
<!--                    <li class="<?php #echo $active3; ?>"><a data-toggle="tab" href="#srequests">Stock Requests <span class="badge"><?php #echo count(select("SELECT * FROM dispensary_tb WHERE request_status='pending' ")); ?></span></a></li>-->
                </ul>
            </div>
            <div class="widget-content tab-content">

                <div id="tab2" class="tab-pane <?php echo $active2; ?>">
                    <form action="" method="post" id="admed" class="form-horizontal" class="frmSearch">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">


                              <div class="control-group">
                                <label class="control-label">Medicine Name:</label>
                                <div class="controls">
                                  <select class="span11"  name="medicine_name" onchange="medcat(this.value);">
									  <option></option>
									  <?php
										  $meddsql = select("SELECT * FROM pharmacy_inventory");
										  foreach($meddsql as $medrow){
									  ?>
									  <option value="<?php echo $medrow['medicine_id']; ?>"><?php echo $medrow['medicine_name']; ?></option>
									  <?php } ?>
									</select>
                                </div>
                              </div>

                              <span id="cat"></span>

                              <div class="control-group">
                                <label class="control-label">Number of Pieces:</label>
                                <div class="controls">
                                  <input type="number" class="span11" placeholder="No. of pieces" name="no_of_piece" required />
                                </div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Request</button>
                              </div>
                          </div>
                      </div>

                    </form>
                </div>


                <div id="tab1" class="tab-pane <?php echo $active; ?>">

					 <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>Stock</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Medicine ID</th>
                              <th>Medicine Name</th>
<!--                              <th>Number of Boxes</th>-->
                              <th>Number of Pieces</th>
                            </tr>
                          </thead>
                          <tbody id="stocklist"></tbody>

						  </table>
						 </div>
						 </div>

                </div>

                <div id="srequests" class="tab-pane <?php echo $active3; ?>">

					 <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Patients</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Medicine ID</th>
                              <th>Medicine Name</th>
                              <th>Number of Boxes</th>
                              <th>Number of Pieces</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="stockrequests"></tbody>

						  </table>
						 </div>
						 </div>

                </div>


            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
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


          <script type="text/javascript" src="assets/js1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css"  href="assets/js1/jquery-ui.css" />

<script>
window.onload = function () {
    document.getElementById('button').onclick = function () {
        document.getElementById('modal').style.display = "none"
    };
};
</script>



       <script>
    function dis(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/dstocklist.php",false);
        xmlhttp.send(null);
        document.getElementById("stocklist").innerHTML=xmlhttp.responseText;
    }
        dis();

        setInterval(function(){
            dis();
        },1000);


    </script>



<script>

        function medcat(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#cat').load('med_cat.php?id='+val, function(){
                $('#loader').html("");
               });
        }

        function pharm_cat(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#pharm').load('loads/pharm-cat.php?id='+val, function(){
                $('#loader').html("");
               });
        }

</script>

<!--
       <script>
    function out_patient_list(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/oldpatient-load.php",false);
        xmlhttp.send(null);
        document.getElementById("outpatientlist").innerHTML=xmlhttp.responseText;
    }
        out_patient_list();

        setInterval(function(){
            out_patient_list();
        },1000);
    </script>
-->

<script type="text/javascript">
    setInterval("my_function();",5000);
    function my_function(){
//      $('#outpatientlist').load('loads/oldpatient-load.php');
        document.getElementById("outpatientlist").innerHTML
    }
  </script>


<!--Auto Complete-->
     <script type="text/javascript">
                 $(document).ready(function()
				 		{
                    $("#search-box").autocomplete(

				{
                        source:'autocomplete.php',
                        minLength:1
                    });
                  });




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
<?php #}else{echo "<script>window.location='404'</script>";}?>
