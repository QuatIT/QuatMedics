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
    </style>
</head>
<body>

<?php
    include 'layout/head.php';

    $success='';
    $error='';

    $patient = new Patient;

//     $birthIDs = Birth::find_num_Birth() + 1;
    $PatientIDs = $patient->find_num_Patient() + 1;

    if(isset($_POST['addApptmnt'])){

        $babyID = substr(filter_input(INPUT_POST, "babylastName", FILTER_SANITIZE_STRING), 0, 5).date('y')."-".trim(sprintf('%06s',$PatientIDs));
//        $babyID = filter_input(INPUT_POST, "babyID", FILTER_SANITIZE_STRING);
        $babyFirstName = filter_input(INPUT_POST, "babyFirstName", FILTER_SANITIZE_STRING);
        $babyOtherName = filter_input(INPUT_POST, "babyOtherName", FILTER_SANITIZE_STRING);
        $babylastName = filter_input(INPUT_POST, "babylastName", FILTER_SANITIZE_STRING);
        $babyName = $babyFirstName.' '.$babyOtherName.' '.$babylastName;
        $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
        $motherName = filter_input(INPUT_POST, "motherName", FILTER_SANITIZE_STRING);
        $fatherName = filter_input(INPUT_POST, "fatherName", FILTER_SANITIZE_STRING);
        $birthTime = filter_input(INPUT_POST, "birthTime", FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
        $status = LIVING;

        $birth = new Birth;

        $baby = $birth->RegisterBaby($babyID,$babyFirstName,$babyOtherName,$babylastName,$babyName,$dob,$motherName,$fatherName,$birthTime,$country,$status);

        if($baby){
           $centerID=$_SESSION['centerID'];

            $insert_baby = insert("INSERT INTO patient(centerID,patientID,firstName,otherName,lastName,dob,guardianName) VALUES('$centerID','$babyID','$babyFirstName','$babyOtherName','$babylastName','$dob','$motherName') ");
//            createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress)

            $success="<script>document.write('Baby Registered Successfullly')
                        window.location.href='center-registrarB'</script>";
        }else{
            $error="Something Happened Somewhere";
        }

    }


?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href=""><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="center-registrarB?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-file"></i><span>Birth Records</span></a> </li>
    <li> <a href="center-registrarD?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-file"></i><span>Death Records</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Registrar" class="tip-bottom"><i class="icon-file"></i> REGISTRAR</a>
        <a title="Birth Records" class="tip-bottom"><i class="icon-file"></i> BIRTH RECORDS</a>
    </div>
  </div>
      <h3>Development is ongoing</h3>

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
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
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
