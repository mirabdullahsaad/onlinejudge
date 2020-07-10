<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        redirect_to("home.php");
    }
    if (isset($_POST['submit'])) {

        $name = htmlentities($_POST["u_name"]);
        $email = htmlentities($_POST["email"]);
        $pass1 = htmlentities($_POST["pass1"]);
        $pass2 = htmlentities($_POST["pass2"]);
        $batch = htmlentities($_POST["batch"]);
        $miuid = htmlentities($_POST["miuid"]);
        $query1 = mysqli_query($connection,"SELECT * FROM admins ORDER BY id DESC");
        $query_username = array();
        $query_email = array();
        while($row = $query1->fetch_assoc()) {
            array_push($query_email, $row['email']);
            array_push($query_username, $row['username']);
        }
        if(array_search($name, $query_username) !== false)
        {
            $_SESSION["message"] = "username already taken";
            redirect_to("register.php");
        }
        if(array_search($email, $query_email) !== false)
        {
            $_SESSION["message"] = "email already taken";
            redirect_to("register.php");
        }
        if ($pass1==$pass2) {
            $password = md5($pass1);
            $privilage = 9;
            $accepted =0;
            $submitted =0;
            $tried =0;
            $sub_info = '{"sub_list":[],"acc_list":[]}';
            $query = "INSERT INTO admins (";
            $query.= " username, batch, miuid, email, hpassword, privilage, accepted, tried, submitted, subinfo";
            $query.= ") VALUES (";
            $query.= "  '{$name}', '{$batch}', '{$miuid}', '{$email}', '{$password}', '{$privilage}', '{$accepted}', '{$tried}', '{$submitted}', '{$sub_info}'";
            $query.= ")";
            $result=mysqli_query($connection,$query);

            if ($result) {
                // Success
                $_SESSION["message"] = "You are Now registered please log in";
                redirect_to("home.php");
            } else {
                // Failure
                $_SESSION["message"] = "Registration failed";
                redirect_to("home.php");
            }
        }
        else
        {
            $_SESSION["message"] = "two password do not match";
            redirect_to("register.php");
        }
    }else {
        //header('location:home.php');
    }
?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<br><br>
<div style="text-align: center;">
    <?php echo message(); ?>
</div>
<br>
<div class="container">
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">sign up for miuoj</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post">
                        <div class="form-group">
                            <input id="email" class="form-control input-sm" placeholder="Email Address"  type="text" name="email" value="" required>
                        </div>
                        <div class="form-group">
                            <input id="username" class="form-control input-sm" placeholder="Username" type="text" name="u_name" value="" required>
                        </div>
                        <div class="form-group">
                            <input id="miubatch" class="form-control input-sm" placeholder="MIU Batch Number" type="text" name="batch" value="" required>
                        </div>
                        <div class="form-group">
                            <input id="miuid" class="form-control input-sm" placeholder="MIU ID" type="text" name="miuid" value="" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control input-sm" placeholder="Password" name="pass1" value="" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" name="pass2" value="" required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Register" class="btn btn-info btn-block" onclick="ajax_f2();">
                    </form>
                </div>
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