<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        redirect_to("home.php");
    }
    if (isset($_POST['login'])) {

    	$name = htmlentities($_POST["u_name"]);
    	$pass1 = htmlentities($_POST["pass1"]);
    	$pass1 = md5($pass1);
        $query = "SELECT * FROM admins WHERE username = '{$name}' AND hpassword = '{$pass1}'";
        $result=mysqli_query($connection,$query);
        if (mysqli_num_rows($result)==1) {
            $row = $result->fetch_assoc();
            $_SESSION['loggedin'] = true;
            setcookie("loggedin", "true", time()+3600);
            $_SESSION['username'] = $name;
            setcookie("username", $name, time()+3600);
            $_SESSION['userid'] = $row['id'];
            setcookie("userid", $row['id'], time()+3600);
            $_SESSION['privilage'] = $row['privilage'];
            setcookie("privilage", $row['privilage'], time()+3600);
            $_SESSION['timestamp'] = 0;
            $_SESSION['message'] = 'You are now logged in ' . $name;

            redirect_to("home.php");
        }
        else
        {
            $_SESSION['message'] = 'username/password combination incorrect';
            redirect_to("login.php");
        }
    	
    }else {
        //redirect_to("register.php");
    }
?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div style="text-align: center;">
	<?php echo message(); ?>
</div>
<br>
<div class="container">    
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
            </div> 
		    <div style="padding-top:30px" class="panel-body" >
		        <form id="loginform" class="form-horizontal" role="form"  method="post">
		            <div style="margin-bottom: 25px" class="input-group">
		                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		                        <input id="login-username" class="form-control" type="text" name="u_name" value="" required>
		                    </div>
		            <div style="margin-bottom: 25px" class="input-group">
		                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		                        <input id="login-password" type="password" class="form-control" name="pass1" value="" required>
		                    </div>
		                <div style="margin-top:10px" class="form-group">
		                    <!-- Button -->
		                    <div class="col-sm-12 controls">
		                    	<input class="btn btn-success" type="submit" name="login" value="login" onclick="ajax_f1();">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-md-12 control">
		                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
		                            Don't have an account! 
		                        <a href="register.php">
		                            Sign Up Here
		                        </a>
		                        </div>
		                    </div>
		                </div>    
		        </form> 
            </div>  
        </div>                   
    </div>  
</div>



<?php include 'footer.php'; ?>	
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>