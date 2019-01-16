<?php
require_once 'assets/core/connection.php';
@session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}


//search and display hospital name
$centerName_sql = select("SELECT * FROM medicalcenter WHERE centerID='".$_SESSION['centerID']."' ");
foreach($centerName_sql as $centerName){}

?>


<!--Header-part-->
<div id="header">
    <h1>
        <a>
             <img src="quatmedics.png" alt="QUATMEDIC LOGO" title="QuatMedic Logo" style="height:50px;" /> | <small><?php echo $centerName['centerName']; ?></small>
        </a>
    </h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<!--
<div class="btn-group rightzero">
    <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a>
    <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
    <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i>
        <span class="label label-important">5</span>
    </a>
    <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
</div>
-->
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
<!--
    <li class="" ><a title="" href="opd-index.php"><i class="icon icon-user"></i> <span class="text">OPD</span></a></li>
    <li class="" ><a title="" href="consult-index.php"><i class="icon icon-briefcase"></i> <span class="text">CONSULTATION</span></a></li>
    <li class="" ><a title="" href="lab-index.php"><i class="icon icon-filter"></i> <span class="text">LABORATORY</span></a></li>
    <li class="" ><a title="" href="pharmacy-index.php"><i class="icon icon-plus-sign"></i> <span class="text">PHARMACY</span></a></li>
    <li class="" ><a title="" href="ward-index.php"><i class="icon icon-home"></i> <span class="text">WARD</span></a></li>
-->
    <li class="dropdown" id="settings">
        <a href="#" data-toggle="dropdown" data-target="#settings" class="dropdown-toggle">
            <i class="icon icon-cog"></i>
            <span class="text">Settings</span>
<!--            <span class="label label-important">5</span> -->
            <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
<!--        <li><a title="" href="#"><i class="icon icon-user"></i> Profile</a></li>-->
        <li><a title="Logout" href="logout"><i class="icon icon-share-alt"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</div>
