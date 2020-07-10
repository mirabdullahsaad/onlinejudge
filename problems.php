<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>

	<?php 

		if (isset($_GET['id']))
		{
		    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	            echo '<div class="container ">';
					echo '<a href="http://localhost/oj/temp_code/submit.php?id='. $_GET['id'] .'" class="btn btn-secondary" style="border: 1px solid #13a22b;">Submit</a>';
	            echo "</div><br>";
	        } 
	        $prob_id = $_GET['id'];
	        $sql = "SELECT * FROM problems WHERE id = $prob_id";
	        $query1 = mysqli_query($connection,$sql);
	        $row = $query1->fetch_assoc();
	        echo '<div class="container" style="margin-bottom: -40px;">';
	            	echo '<object style="margin-left: 18%;" width="70%" height="500" type="application/pdf" data="problems/'. $row['filename'] .'?#zoom=85&scrollbar=0&toolbar=0&navpanes=0" id="pdf_content"><p>Sorry this PDF cannot be displayed.</p></object>';
	        echo "</div>";
		}
		else
		{
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['privilage'] < 9) {
	            echo '<div class="container ">';
					echo '<a href="add_new_program.php" class="btn btn-secondary" style="border: 1px solid #13a22b; margin-right:15px;">Add new problem</a><a href="edit_program.php" class="btn btn-secondary" style="border: 1px solid #13a22b;">Edit problem</a>';
	            echo "</div><br>";
	            
	        } 
	?>

			<div class="container" style="margin-bottom: -40px;">
				<div style="text-align: center; color: #000;">
				    <?php echo message(); ?>
				</div>
			    <div class="row">
			        <div class="col-md-12">
			            <div class="panel panel-info">
			                <div class="panel-heading">
			                    <h3 class="panel-title" style="text-align: center;font-size: 15px">SELECT ONE OF THE FOLLOWING PROBLEMS TO SOLVE</h3>
			                </div>
			                <ul class="list-group">
			                    <div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;background-color:#eef5e9;padding: 5px 15px;">
			                    	<div class="col-xs-2">ID</div>
			                    	<div class="col-xs-4">Title</div>
			                    	<div class="col-xs-2">Level</div>
			                    	<div class="col-xs-2">Tried</div>
			                    	<div class="col-xs-2">Solved</div>
			                    </div>
			                    <?php

				                    $query1 = mysqli_query($connection,"SELECT * FROM problems");
									$r_array = array();
									while($row = $query1->fetch_assoc()) {
										array_push($r_array, $row);
								    }
			                    	$i=1;
			                    	foreach ($r_array as $key => $value) {
			                            $vu = json_decode($value['subinfo'], true);
			                    		echo '<div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;padding: 5px 15px;">';
				                    		echo '<a href="problems.php?id='. $value['id'] .'"><div class="col-xs-2">'. $i .'</div></a>';
					                    	echo '<a href="problems.php?id='. $value['id'] .'"><div class="col-xs-4">'. $value['name'] .'</div></a>';
					                    	echo '<div class="col-xs-2">'. $value['level'] .'</div>';
					                    	echo '<div class="col-xs-2">'. count($vu['submitted']) .'</div>';
					                    	echo '<div class="col-xs-2">'. count($vu['solved']) .'</div>';
				                    	echo '</div>';
				                    	$i++;
			                    	}
			                    ?>
			                </ul>
			            </div>
			        </div>
			    </div>
			</div>

	<?php
		}    
    ?>
    
    


<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>