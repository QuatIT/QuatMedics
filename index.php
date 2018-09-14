<?php
include 'assets/core/connection.php';
session_start();

$success = '';
$error = '';

if(isset($_POST['btnSave'])){

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $centerAdmin = User::centerAdminLogin($username,$password);

    if($centerAdmin){
        if(count($centerAdmin) >=1 ){
            foreach($centerAdmin as $centerAdminRow){
                $usernameRow = $centerAdminRow['userName'];
                $passwordRow = $centerAdminRow['password'];
                $accessLevelRow = $centerAdminRow['accessLevel'];
                $centerIDRow = $centerAdminRow['centerID'];
            }

            if($accessLevelRow = 'center_admin'){

                $_SESSION['username'] = $usernameRow;
                $_SESSION['password'] = $passwordRow;
                $_SESSION['accessLevel'] = $accessLevelRow;
                $_SESSION['centerID'] = $centerIDRow;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='medics-index' </script>";

            }else{
                $error = "<script>document.write('WRONG USERNAME AND PASSWORD');
                                    window.location.href='index' </script>";
            }
        }else{
                $error = "<script>document.write('YOUR ACCOUNT CANNOT BE FOUND');
                                    window.location.href='index' </script>";
            }
    }else{

        //centerUser login
        $centerUser = User::centerUserLogin($username,$password);

        if(count($centerUser) >= 1 ){
            foreach($centerUser as $centerUserRow){
                $usernameRow1 = $centerUserRow['userName'];
                $passwordRow1 = $centerUserRow['password'];
                $accessLevelRow1 = $centerUserRow['accessLevel'];
                $centerIDRow1 = $centerUserRow['centerID'];
            }

            if($accessLevelRow1 = 'OPD'){

                $_SESSION['username'] = $usernameRow1;
                $_SESSION['password'] = $passwordRow1;
                $_SESSION['accessLevel'] = $accessLevelRow1;
                $_SESSION['centerID'] = $centerIDRow1;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='opd-index' </script>";

            }elseif($accessLevelRow1 = 'CONSULTATION'){

                $_SESSION['username'] = $usernameRow1;
                $_SESSION['password'] = $passwordRow1;
                $_SESSION['accessLevel'] = $accessLevelRow1;
                $_SESSION['centerID'] = $centerIDRow1;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='consult-index' </script>";

            }elseif($accessLevelRow1 = 'WARD'){

                $_SESSION['username'] = $usernameRow1;
                $_SESSION['password'] = $passwordRow1;
                $_SESSION['accessLevel'] = $accessLevelRow1;
                $_SESSION['centerID'] = $centerIDRow1;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='ward-index' </script>";

            }elseif($accessLevelRow1 = 'PHARMACY'){

                $_SESSION['username'] = $usernameRow1;
                $_SESSION['password'] = $passwordRow1;
                $_SESSION['accessLevel'] = $accessLevelRow1;
                $_SESSION['centerID'] = $centerIDRow1;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='pharmacy-index' </script>";

            }elseif($accessLevelRow1 = 'LABORATORY'){

                $_SESSION['username'] = $usernameRow1;
                $_SESSION['password'] = $passwordRow1;
                $_SESSION['accessLevel'] = $accessLevelRow1;
                $_SESSION['centerID'] = $centerIDRow1;

                $success = "<script>document.write('LOGIN SUCCESSFUL');
                                    window.location.href='lab-index' </script>";

            }else{
                $error = "<script>document.write('WRONG USERNAME AND PASSWORD');
                                    window.location.href='index' </script>";
            }
        }else{
                $error = "<script>document.write('YOUR ACCOUNT CANNOT BE FOUND');
                                    window.location.href='index' </script>";
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
                      <?php
                      } ?>
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
            <form id="recoverform" action="" method="post" class="form-vertical">
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
