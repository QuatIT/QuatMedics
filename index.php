<?php
include 'assets/core/connection.php';

if(isset($_POST['btnSave'])){

    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));

    //login detail
    $centerUserLogin = User::centerUserLogin($username,$password);

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

            echo "<script>document.write('LOGIN SUCCESSFUL');
                    window.location.href='medics-index'</script>";
        }elseif($accessLevel_row = 'CONSULTATION'){}elseif($accessLevel_row = 'WARD'){}elseif($accessLevel_row = 'PHARMACY'){}elseif($accessLevel_row = 'LABORATORY'){}
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
            <form id="loginform" class="form-vertical" action="">
				 <div class="control-group normal_text">
                     <h3>QUAT MEDICS ADMIN</h3>
                </div>
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
            <form id="recoverform" action="#" class="form-vertical">
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
