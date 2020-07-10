<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container hero">
    <div class="row">
        <div class="col-lg-5 col-lg-offset-1 col-md-6 col-md-offset-0">
            <?php 
                echo message();
            ?>
            <h1>Welcome to the MIU Online Judge</h1>
            <p>Here you will find hundreds of problems. They are like the ones used during programming contests, and are available in HTML and PDF formats. You can submit your sources in a variety of languages, trying to solve any of the problems available in our database.</p>
        </div>
        <div class="col-lg-5 col-lg-offset-0 col-md-5 col-md-offset-1 hidden-xs hidden-sm phone-holder">
            <div class="iphone-mockup "><img src="front.jpg" class="device img-rounded"></div>
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