<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
</head>
<body style="background-color:#fff;">
<?php
require_once 'assets/core/connection.php';
session_start();
if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
	//search and display hospital name
$centerName_sql = select("SELECT * FROM medicalCenter WHERE centerID='".$_SESSION['centerID']."' ");
foreach($centerName_sql as $centerName){}
}
//    include 'layout/idhead.php';

    if(isset($_GET['pid'])){
        $patientID = $_GET['pid'];
        $sql = select("SELECT * from patient WHERE patientID='$patientID'");
        foreach($sql as $patientrow){}
    }
?>
<div id="content" style="background-color:#fff;">
  <div class="container" style="background-color:#fff;">
      <div class="row-fluid" style="background-color:#fff; height:400px;">
        <div class="widget-box" style="width:600px; height:auto; margin:auto;">
            <div class="widget-content tab-content">
                <table class="table" width="100%" height="60%" border="2" cellpadding="0" style="border-style:dotted;">
                    <tbody>
                        <tr class="text-center">
                        <td colspan="3" style="border:0px;">
                            <h4 class="text-center">
                                <span style="color:#1860c3;">QUAT</span>MEDIC | <span style="color:#49cced;"><?php echo $centerName['centerName']; ?></span>
                            </h4>
                        </td>
                        </tr>
                        <tr class="text-center">
                        <td colspan="3">
                            <h5 class="text-center"> PATIENT IDENTITY CARD</h5>
                        </td>
                        </tr>
                        <tr>
                            <td style="width:35%; text-align:center;" rowspan="5"> 
								<?php if(empty($patientrow['patient_image'])){?>
								<span class="text-center"> No Photo</span>
								<?php }else{?>
								<img src="<?php echo $patientrow['patient_image'];?>" style="width:320px; height:200px;" />
								<?php }?>
							</td>
                            <td> ID Number : </td>
                            <td><?php echo $patientrow['patientID'];?></td>
                        </tr>
                        <tr>
                            <td> Name : </td>
                            <td><?php echo $patientrow['lastName']." ".$patientrow['firstName']." ".$patientrow['otherName'];?></td>
                        </tr>
                        <tr> <td> DOB : </td><td><?php echo $patientrow['dob'];?></td></tr>
                        <tr> <td> Gender : </td><td><?php echo $patientrow['gender'];?></td></tr>
                        <tr> <td> Phone : </td><td><?php echo $patientrow['phoneNumber'];?></td></tr>
                    </tbody>
                </table>
            </div>
          </div>
      </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/maruti.js"></script>
<script type="text/javascript">
window.print();
</script>
</body>
</html>
