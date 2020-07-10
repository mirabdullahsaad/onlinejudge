<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>
<?php
	
	$query1 = mysqli_query($connection,"SELECT * FROM admins");
	$r_array = array();
	while($row = $query1->fetch_assoc()) {
		array_push($r_array, $row);
    }
    uasort($r_array, 'cmp');
    
?> 
<div class="container" style="margin-bottom: -40px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title" style="text-align: center;font-size: 15px">Welcome you all to the MIU OJ rank board!</h3>
                </div>
                <ul class="list-group">
                    <div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;background-color:#eef5e9;padding: 5px 15px;">
                    	<div class="col-xs-2">Ranking</div>
                    	<div class="col-xs-2">Username</div>
                    	<div class="col-xs-2">Batch</div>
                    	<div class="col-xs-2">Solved</div>
                    	<div class="col-xs-2">Tried</div>
                    	<div class="col-xs-2">Submission</div>
                    </div>
                    <?php
                    	$i=1;
                    	foreach ($r_array as $key => $value) {
                            $vu = json_decode($value['subinfo'], true);
                    		echo '<div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;padding: 5px 15px;">';
	                    		echo '<div class="col-xs-2">'. $i .'</div>';
		                    	echo '<div class="col-xs-2">'. $value['username'] .'</div>';
		                    	echo '<div class="col-xs-2">'. $value['batch'] .'</div>';
		                    	echo '<div class="col-xs-2">'. $value['accepted'] .'</div>';
		                    	echo '<div class="col-xs-2">'. count($vu['sub_list']) .'</div>';
		                    	echo '<div class="col-xs-2">'. $value['submitted'] .'</div>';
	                    	echo '</div>';
	                    	$i++;
                    	}
                    ?>
                </ul>
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