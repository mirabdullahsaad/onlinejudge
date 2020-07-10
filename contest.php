<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>

			<?php 
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<p style="color:#000;">' . "Welcome to the MIUOJ, " . $_SESSION['username'] . " :)". '</p>';
                } else {
                   echo '<p style="color:#000;">Please log in first to see this page.</p>';
                }
            ?>
         
<!--<div class="col-md-3 circleStats">
            <div class="span2" ontablet="span4" ondesktop="span2">
                <div class="circleStatsItemBox yellow">
                    <div class="header">Status</div>
                    <span class="percent">percent</span>
                    <div class="circleStat">
                        <span class="whiteCircleData" id="stat_status_percentage_data">0</span>
                    </div>      
                    <div class="footer">
                        <span class="count">
                            <span class="number" id="stat_optimized_total">0</span>
                            <span class="unit">images</span>
                        </span>
                        <span class="sep"> / </span>
                        <span class="value">
                            <span class="number" id="stat_optimizable_total">57</span>
                            <span class="unit">images</span>
                        </span> 
                    </div>
                </div>
            </div>
        </div>-->

<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>