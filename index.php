<?php
include 'assets/core/connection.php';
session_start();

$success = '';
$error = '';

if(isset($_POST['btnSave'])){

    $username = trim(filter_input(INPUT_POST,"username", FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST,"password", FILTER_SANITIZE_STRING));

    //staff login detail
    $centerUserLogin = User::centerUserLogin($username,$password);

    if($centerUserLogin){
    if(count($centerUserLogin) >= 1){
        foreach($centerUserLogin as $centerLogin){
            $username_row = $centerLogin['username'];
            $password_row = $centerLogin['password'];
            $accessLevel_row = $centerLogin['accessLevel'];
            $centerID_row = $centerLogin['centerID'];
        }

        if($accessLevel_row = 'OPD'){

            $_SESSION['username'] = $username_row;
            $_SESSION['password'] = $password_row;
            $_SESSION['accessLevel'] = $accessLevel_row;
            $_SESSION['centerID'] = $centerID_row;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='opd-index'</script>";

        }elseif($accessLevel_row = 'CONSULTATION'){

            $_SESSION['username'] = $username_row;
            $_SESSION['password'] = $password_row;
            $_SESSION['accessLevel'] = $accessLevel_row;
            $_SESSION['centerID'] = $centerID_row;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='consult-index'</script>";

        }elseif($accessLevel_row = 'WARD'){

            $_SESSION['username'] = $username_row;
            $_SESSION['password'] = $password_row;
            $_SESSION['accessLevel'] = $accessLevel_row;
            $_SESSION['centerID'] = $centerID_row;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='ward-index'</script>";

        }elseif($accessLevel_row = 'PHARMACY'){

            $_SESSION['username'] = $username_row;
            $_SESSION['password'] = $password_row;
            $_SESSION['accessLevel'] = $accessLevel_row;
            $_SESSION['centerID'] = $centerID_row;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='pharmacy-index'</script>";

        }elseif($accessLevel_row = 'LABORATORY'){

            $_SESSION['username'] = $username_row;
            $_SESSION['password'] = $password_row;
            $_SESSION['accessLevel'] = $accessLevel_row;
            $_SESSION['centerID'] = $centerID_row;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='lab-index'</script>";

        }else{
           $error = "WRONG USERNAME AND PASSWORD1";
        }
    }
    }else{

        //centerAdmin login = medics-index
        $centerAdminLogin = User::centerAdminLogin($username,$password);

        if(count($centerAdminLogin) >= 1){
            foreach($centerAdminLogin as $centerAdmin){
                $adminUsername = $centerAdmin['userName'];
                $adminPassword = $centerAdmin['password'];
                $adminAccessLevel = $centerAdmin['accessLevel'];
                $adminCenterID = $centerAdmin['centerID'];
            }

            if($adminAccessLevel = 'center_admin'){

            $_SESSION['username'] = $adminUsername;
            $_SESSION['password'] = $adminPassword;
            $_SESSION['accessLevel'] = $adminAccessLevel;
            $_SESSION['centerID'] = $adminCenterID;

            $success = "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='medics-index'</script>";

        }else{
           $error = "WRONG USERNAME AND PASSWORD2";
        }

        }else{
           $error = "WRONG USERNAME AND PASSWORD";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
        <title>QUAT MEDICS</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/maruti-login.css" />
    </head>
    <body>
        <div id="loginbox">
            <form id="loginform" class="form-vertical" action="" method="post">
				 <div class="control-group normal_text">
                     <h3>QUAT MEDICS ADMIN</h3>
                </div>

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
                <?php } ?>

                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on"><i class="icon-user"></i></span><input type="text" name="username" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-inverse" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><input type="submit" name="btnSave" class="btn btn-primary" value="Login" /></span>
                </div>
            </form>
            <form id="recoverform" action="" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you a recovery guide</p>

                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>

                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-inverse" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-info" value="Recover" /></span>
                </div>
            </form>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/maruti.login.js"></script>
    </body>
</html>
