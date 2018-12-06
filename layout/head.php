<?php
require_once 'assets/core/connection.php';
@session_start();
$dateToday = trim(date('Y-m-d'));

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }
}

$centerID=$_SESSION['centerID'];

$LICENCE_UPLOAD = PARENT_DIR.$centerID.'/licence/';
$LAB_RESULT_UPLOAD = PARENT_DIR.$centerID.'/labresults/';
$PATIENT_UPLOAD = PARENT_DIR.$centerID.'/patient/';

//search and display hospital name
$centerName_sql = select("SELECT * FROM medicalCenter WHERE centerID='".$_SESSION['centerID']."' ");
foreach($centerName_sql as $centerName){}

?>

<!--Header-part-->
<div id="header">
  <h1><a> <span style="color:#1860c3;">Q<i class="fa fa-stethoscope"></i>AT</span>MEDIC | <small><?php echo $centerName['centerName']; ?></small></a> </h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<div class="btn-group rightzero">
    <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a>
    <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
    <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i>
        <span class="label label-important">5</span>
    </a>
    <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
</div>
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">

      <?php if($_SESSION['accessLevel']=='OPD'){ ?>
       <li class="" ><a title="" href="medics-index"><i class="icon icon-home"></i> <span class="text">HOME</span></a></li>
    <li class="" ><a title="" href="opd-index"><i class="icon icon-user"></i> <span class="text">OPD</span></a></li>
      <?php } ?>

      <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
       <li class="" ><a title="" href="medics-index?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-home"></i> <span class="text">HOME</span></a></li>
    <li class="" ><a title="" href="consult-index?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-briefcase"></i> <span class="text">CONSULTATION</span></a></li>
      <?php } ?>

      <?php if($_SESSION['accessLevel']=='LABORATORY'){ ?>
      <li class="" ><a title="" href="medics-index"><i class="icon icon-home"></i> <span class="text">HOME</span></a></li>
    <li class="" ><a title="" href="lab-index"><i class="icon icon-filter"></i> <span class="text">LABORATORY</span></a></li>
      <?php } ?>

      <?php if($_SESSION['accessLevel']=='PHARMACY'){ ?>
    <li class="" ><a title="" href="pharmacy-index"><i class="icon icon-plus-sign"></i> <span class="text">PHARMACY</span></a></li>
      <?php } ?>

      <?php #if($_SESSION['accessLevel']=='PHARMACY'){ ?>
    <li class="" ><a title="" href="emergency-index"><i class="icon icon-exclamation-sign"></i> <span class="text">EMERGENCY</span></a></li>
      <?php #} ?>

      <?php if($_SESSION['accessLevel']=='WARD'){ ?>
    <li class="" ><a title="" href="ward-index"><i class="icon icon-home"></i> <span class="text">WARD</span></a></li>
      <?php } ?>
<?php if($_SESSION['username']!='rik'){ ?>
    <li class="" ><a title="" href="center-registrarB?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-file"></i> <span class="text">BIRTH AND DEATH</span></a></li>

    <li class="dropdown" id="settings">
        <a href="#" data-toggle="dropdown" data-target="#settings" class="dropdown-toggle">
            <i class="icon icon-cog"></i>
            <span class="text">Settings (<?php echo $_SESSION['username']; ?>)</span>
            <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
        <li><a title="" href="#"><i class="icon icon-user"></i> Profile</a></li>
          <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
        <li><a title="Logout" href="logout?c=<?php echo $_GET['roomID']; ?>"><i class="icon icon-share-alt"></i> Logout</a></li>
          <?php }else{ ?>
        <li><a title="Logout" href="logout"><i class="icon icon-share-alt"></i> Logout</a></li>
          <?php } ?>
      </ul>
    </li>
<?php } ?>
  </ul>


  <ul class="nav">

      <?php if($_SESSION['username']=='rik'){ ?>
<!--
       <li class="" ><a title="" href="medics-index"><i class="icon icon-home"></i> <span class="text">HOME</span></a></li>
    <li class="" ><a title="" href="opd-index"><i class="icon icon-user"></i> <span class="text">OPD</span></a></li>
-->

    <li class="" ><a title="" href="consult-index?roomID=<?php echo $_GET['roomID']; ?>"><i class="icon icon-briefcase"></i> <span class="text">CONSULTATION</span></a></li>
    <li class="" ><a title="" href="lab-index"><i class="icon icon-filter"></i> <span class="text">LABORATORY</span></a></li>
    <li class="" ><a title="" href="pharmacy-index"><i class="icon icon-plus-sign"></i> <span class="text">PHARMACY</span></a></li>
    <li class="" ><a title="" href="ward-index"><i class="icon icon-home"></i> <span class="text">WARD</span></a></li>
    <li class="" ><a title="" href="center-registrarB"><i class="icon icon-file"></i> <span class="text">BIRTH AND DEATH</span></a></li>
    <li class="dropdown" id="settings">
        <a href="#" data-toggle="dropdown" data-target="#settings" class="dropdown-toggle">
            <i class="icon icon-cog"></i>
            <span class="text">Settings</span>
<!--            <span class="label label-important">5</span> -->
            <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
        <li><a title="" href="#"><i class="icon icon-user"></i> Profile</a></li>
          <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
        <li><a title="Logout" href="logout?c=<?php echo $_GET['roomID']; ?>"><i class="icon icon-share-alt"></i> Logout_consulting</a></li>
          <?php }else{ ?>
        <li><a title="Logout" href="logout"><i class="icon icon-share-alt"></i> Logout</a></li>
          <?php } ?>

      </ul>
    </li><?php } ?>
  </ul>
</div>

<script>
$('input[type=text]').val (function () {
    return this.value.toUpperCase();
});

$('input[type=email]').val (function () {
    return this.value.toUpperCase();
});

$('textarea').val (function () {
    return this.value.toUpperCase();
});
</script>
