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


	$medIDs = count(select("SELECT * FROM pharmacy_inventory")) + 1;

    if(isset($_POST['btnSave'])){

      $medID = substr(filter_input(INPUT_POST, "medicine_name", FILTER_SANITIZE_STRING), 0, 3)."-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$medIDs);
      $staffID = $staffID['userID'];
      $medicine_name = filter_input(INPUT_POST, "medicine_name", FILTER_SANITIZE_STRING);
      $medicine_type = filter_input(INPUT_POST, "medicine_type", FILTER_SANITIZE_STRING);
      $no_of_boxes = filter_input(INPUT_POST, "no_of_boxes", FILTER_SANITIZE_STRING);
      $no_of_piece = filter_input(INPUT_POST, "no_of_piece", FILTER_SANITIZE_STRING);
      $no_of_bottles = filter_input(INPUT_POST, "no_of_bottles", FILTER_SANITIZE_STRING);
      $expire_date = filter_input(INPUT_POST, "expire_date", FILTER_SANITIZE_STRING);
      $manufacture_date = filter_input(INPUT_POST, "manufacture_date", FILTER_SANITIZE_STRING);
      $company_name = filter_input(INPUT_POST, "company_name", FILTER_SANITIZE_STRING);
      $invoice_number = filter_input(INPUT_POST, "invoice_number", FILTER_SANITIZE_STRING);
      $unit_price = filter_input(INPUT_POST, "unit_price", FILTER_SANITIZE_STRING);


		$chkmed = select("SELECT * FROM pharmacy_inventory WHERE medicine_name='$medicine_name' ");
		if($chkmed >=1){
			$errorr = "MEDICINE ALREADY EXISTS. PLEASE GO TO YOUR STOCK TO UPDATE";
		}else{


		$store = insert("INSERT INTO pharmacy_inventory(medicine_id,medicine_name,medicine_type,no_of_boxes,no_of_piece,no_of_bottles,expire_date,manufacture_date,company_name,invoice_number,unit_price,entered_by,unit_price,centerID,dateRegistered) VALUES('$medID','$medicine_name','$medicine_type','$no_of_boxes','$no_of_piece','$no_of_bottles','$expire_date','$manufacture_date','$company_name','$invoice_number','$unit_price','".$_SESSION['username']."','$unit_price','".$_SESSION['centerID']."',CURDATE() ) ");

		if($store){
            $success = $medicine_name." stock taken successfully";
        }else{
            $error = "Stock failed";
        }

    }
    }


    ?>





<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
<!--
    <ul>
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li class="active"> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    <li><a href="consult-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
-->
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
      <h3 class="quick-actions">PHARMACY INVENTORY</h3>
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

                    <li class="<?php echo $active2; ?>"><a data-toggle="tab" href="#tab2">Add Stock </a></li>
                    <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#tab1">Stock List</a></li>
                    <li class="<?php echo $active3; ?>"><a data-toggle="tab" href="#srequests">Stock Requests <span class="badge"><?php echo count(select("SELECT * FROM dispensary_tb WHERE request_status='pending' ")); ?></span></a></li>
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
                                  <input type="text" class="span11" placeholder="Medicine Name" id="search-box" name="medicine_name" required />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Medicine Category :</label>
                               <div class="controls">
                                  <select name="medicine_type" class="span11" onchange="pharm_cat(this.value);">

                                        <option value=""></option>
                                        <option value="Capsule">Capsule</option>
                                        <option value="Tablet">Tablet</option>
                                        <option value="Syrup">Syrup</option>
                                        <option value="Suppositories">Suppositories</option>
<!--                                        <option value="Liquid">Liquid</option>-->
                                        <option value="Drops">Drops</option>
                                        <option value="Inhalers">Inhalers</option>
                                        <option value="Injections">Injections</option>
                                        <option value="Implants">Implants</option>

                                   </select>
                                </div>
                              </div>

<!--
                              <div class="control-group">
                                <label class="control-label">Mode of Payment:</label>
                                <div class="controls">
                                  <select class="span11" name="mode" onchange="modey(this.value);">
                                        <option value=""></option>
                                        <option value="Private">Private</option>
                                        <option value="Insurance">Health Insurance</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                              </div>
                             <span id="modeload"></span>
-->
                              <div class="control-group">
                                <label class="control-label">Number of Boxes:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="No. of boxes" name="no_of_boxes" required />
                                </div>
                              </div>

							  <span id="pharm"></span>

<!--
                              <div class="control-group">
                                <label class="control-label">Other Health Details :</label>
                                <div class="controls">
                                    <textarea class="span11" name="otherHealth"></textarea>
                                </div>
                              </div>
-->
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">

                              <?php #if(!empty($_GET['pid'])){ ?>
                               <div class="control-group">
                                <label class="control-label">Expiry Date :</label>
                                <div class="controls">
                                  <input type="date" required id="FullName" class="span11" placeholder="Expire Date" name="expire_date" />
                                </div>
                              </div>
                          <?php #}else{echo '<span id="fname"></span>';} ?>

                              <div class="control-group">
                                <label class="control-label">Manufacture Date :</label>
                                <div class="controls">
                                  <input type="date" class="span11" placeholder="Manufacture Date" name="manufacture_date" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Company Name</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="company_name" placeholder="Company Name" required />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Invoice Number</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="invoice_number" placeholder="Invoice Number" required />
                                </div>
                              </div>


                              <div class="control-group">
                                <label class="control-label">Unit Price</label>
                                <div class="controls">
                                  <input type="number"  class="span11" name="unit_price" placeholder="Unit Price" required />
                                </div>
                              </div>

<!--
                               <div class="control-group">
                                <label class="control-label">Assign Consulting Room</label>
                                <div class="controls">
                                  <select name="consultRoom">
                                    <option value="default"> -- Select Consulting Room --</option>
                                      <?php
//                                        $consultingroom = Consultation::find_consultingroom();
//                                        foreach($consultingroom as $roomRow){
                                      ?>
                                    <option value="<?php #echo $roomRow['roomID'];?>"> <?php #echo $roomRow['roomName'];?></option>
                                      <?php #}?>
                                  </select>
                                </div>
                                  <div class="controls"></div>
                              </div>
-->

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Save</button>
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
                              <th>Number of Boxes</th>
                              <th>Number of Pieces</th>
<!--
                              <th>Request Status</th>
                              <th>Requested By</th>
-->
                              <th>Action</th>
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
                        <h5>Pending Request</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Medicine ID</th>
                              <th>Medicine Name</th>
<!--                              <th>Number of Boxes</th>-->
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
        xmlhttp.open("GET","loads/stocklist.php",false);
        xmlhttp.send(null);
        document.getElementById("stocklist").innerHTML=xmlhttp.responseText;
    }
        dis();

        setInterval(function(){
            dis();
        },1000);


    </script>


       <script>
    function stock(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/stockrequest.php",false);
        xmlhttp.send(null);
        document.getElementById("stockrequests").innerHTML=xmlhttp.responseText;
    }
        stock();

        setInterval(function(){
            stock();
        },1000);


    </script>



<script>

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
