<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/maruti-style.css" />
<link rel="stylesheet" href="../css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="../assets/css/font-awesome2.css" />
    <style>
        .active{
            background-color: #209fbf;
        }

    </style>
    <style>
    .control-label{
        font-weight: bolder;
        text-transform: uppercase;
    }
    .labell{
        font-weight: bolder;
        text-transform: uppercase;
    }
    #sidebar ul li{
/*        font-weight: bolder;*/
        text-transform: uppercase;
    }
</style>
</head>

<body>

<!--Header-part-->
<div id="header">
  <h1><a href="index.html"> QUATMEDIC ADMIN</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=" dropdown" id="settings">
        <a href="#" data-toggle="dropdown" data-target="#settings" class="dropdown-toggle">
            <i class="icon icon-cog"></i>
            <span class="text">Settings</span>
            <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
        <li><a title="" href="#"><i class="icon icon-user"></i> Profile</a></li>
        <li><a title="Logout" href="../logout"><i class="icon icon-share-alt"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</div>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li class="active"><a href="index"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
    <li><a href="medcenter-index"><i class="icon icon-plus-sign"></i> <span>Medical Centers</span></a></li>
    <li><a href="#"><i class="icon icon-calendar"></i> <span>Subscriptions</span></a> </li>
    <li><a href="sms_request"><i class="icon icon-envelope"></i> <span>SMS Request</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    </div>
  </div>
  <div class="container-fluid">

   	<div class="quick-actions_homepage">
    <ul class="quick-actions">
          <li> <a href="#"> <i class="icon-graph"></i> Site Views </a> </li>
          <li> <a href="medcenter-index"> <i class="icon-home"></i> Medical Centers</a> </li>
          <li> <a href="#"> <i class="icon-people"></i> Doctors </a> </li>
          <li> <a href="#"> <i class="icon-user"></i> Nurses </a> </li>
          <li> <a href="#"> <i class="icon-client"></i> Patients </a> </li>
          <li> <a href="#"> <i class="icon-calendar"></i> Appointments </a> </li>
        </ul>
   </div>
   	<div class="quick-actions_homepage">
    <ul class="quick-actions">
          <li> <a href="#"> <i class="icon-dashboard"></i> ToBeSet </a> </li>
          <li> <a href="#"> <i class="icon-shopping-bag"></i> ToBeSet </a> </li>
          <li> <a href="#"> <i class="icon-web"></i> ToBeSet </a> </li>
          <li> <a href="#"> <i class="icon-people"></i> ToBeSet </a> </li>
          <li> <a href="#"> <i class="icon-calendar"></i> ToBeSet </a> </li>
          <li> <a href="#"> <i class="icon-calendar"></i> ToBeSet </a> </li>
        </ul>
   </div>
  </div>
<!--</div>-->
<!--</div>-->
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
</div>
<script src="../js/excanvas.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.custom.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.flot.min.js"></script>
<script src="../js/jquery.flot.resize.min.js"></script>
<script src="../js/jquery.peity.min.js"></script>
<script src="../js/fullcalendar.min.js"></script>
<script src="../js/maruti.js"></script>
<script src="../js/maruti.dashboard.js"></script>
<script src="../js/maruti.chat.js"></script>


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
