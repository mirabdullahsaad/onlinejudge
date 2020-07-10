<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>

<?php
	echo message(); 
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	    $sql = "SELECT * FROM admins WHERE id = '{$_SESSION['userid']}'";
        $query1 = mysqli_query($connection,$sql);
        $row = $query1->fetch_assoc();

		$queryw = mysqli_query($connection,"SELECT * FROM admins");
		$r_array = array();
		while($roww = $queryw->fetch_assoc()) {
			array_push($r_array, $roww);
    	}
    	uasort($r_array, 'cmp');
        ?>
        <div class="container">
		    <div class="row">
		        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
		            <div class="panel panel-info">
		                <div class="panel-heading">
		                    <h3 class="panel-title"><?php echo $row['username']; ?></h3>
		                </div>
		                <div class="panel-body">
		                    <div class="row">
		                        <div class=" col-md-9 col-lg-9 "> 
		                            <table class="table table-user-information">
		                                <tbody>
		                                    <tr>
		                                        <td>Email:</td>
		                                        <td><a href="#"><?php echo $row['email']; ?></a></td>
		                                    </tr>
		                                    <tr>
		                                        <td>ID:</td>
		                                        <td><?php echo $row['miuid']; ?></td>
		                                    </tr>
		                                    <tr>    
		                                        <td>Batch:</td>
		                                        <td><?php echo $row['batch']; ?></td>
		                                    </tr>
		                                    <tr>
		                                        <td>Place:</td>
		                                        <td><?php
		                                        	$i=0;
		                                        	foreach ($r_array as $value) {
		                                        		if ($value['username'] == $row['username']) {
		                                        			echo $i+1;
		                                        			break;
		                                        		}
		                                        		$i++;
		                                        	}
		                                        	
		                                         ?></td>
		                                    </tr>
		                                    <tr>
		                                        <td>Solved:</td>
		                                        <td><?php echo $row['accepted']; ?></td>
		                                    </tr>
		                                    <tr>
		                                        <td>Tried:</td>
		                                        <td><?php 
		                                        	$vu = json_decode($row['subinfo'], true);
		                                        	echo count($vu['sub_list']);
		                                        ?></td>
		                                    </tr>
		                                    <tr>
		                                        <td>Submission:</td>
		                                        <td><?php echo $row['submitted']; ?></td>
		                                    </tr>
		                                </tbody>
		                            </table>
	                                <ul class="nav nav-tabs">
	                                    <li class="active"><a data-toggle="tab" href="#home">Problem you tried</a></li>
	                                    <li><a data-toggle="tab" href="#menu1">Problem You solved</a></li>
	                                </ul>
	                                <div class="tab-content">
	                                    <div id="home" class="tab-pane fade in active">
	                                        <h3>Problem you tried</h3>
	                                        <p style="background-color: #dff0d8; padding: 10px;border-radius:5px;"><?php
	                                        	foreach ($vu['sub_list'] as $key => $value) {
	                                        		echo '<span style="background-color:#fcf8e3;padding:2px;border-radius:5px;margin-left:8px;">' . $value . '</span>';
	                                        	}
	                                        ?></p>
	                                    </div>
	                                    <div id="menu1" class="tab-pane fade">
	                                        <h3>Problem You solved</h3>
	                                        <p style="background-color: #dff0d8; padding: 10px;border-radius:5px;"><?php
	                                        	foreach ($vu['acc_list'] as $key => $value) {
	                                        		echo '<span style="background-color:#fcf8e3;padding:2px;border-radius:5px;margin-left:8px;">' . $value . '</span>';
	                                        	}
	                                        ?></p>
	                                    </div>
	                                </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
        
<?php    } else {
	    header('location:home.php');
	}
?>
         


<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>