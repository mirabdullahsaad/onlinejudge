<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>

	<?php 
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['privilage'] < 9)
		{
			if (isset($_POST['submit'])) {
				$_SESSION["message"]= '';
				$file_name = '';
				$pro_id = $_POST["problem_id"];
				$sql2= "SELECT * FROM problems WHERE id = $pro_id";
			    $query2 = mysqli_query($connection,$sql2);
			    $row = $query2->fetch_assoc();
			    $fi_name = $row['filename'];
				if(isset($_FILES['pdf'])){
				    $errors= '';
				    $file_name = $_FILES['pdf']['name'];
				    $file_size =$_FILES['pdf']['size'];
				    $file_tmp =$_FILES['pdf']['tmp_name'];
				    $file_type=$_FILES['pdf']['type'];
				    $file_ext=strtolower($file_name);
				    $v = explode('.',$file_ext);
				    $file_ext=end($v);
				      
				    $expensions= array("pdf");
				      
				    if(in_array($file_ext,$expensions)=== false){
				       $errors .= "extension not allowed, please choose a PDF file . ";
				       $_SESSION["message"].= "extension not allowed, please choose a PDF file.<br>";
				    }
				      
				    if($file_size > 1048576){
				       $errors.='File size must be excately 1 MB.<br>';
				       $_SESSION["message"].= 'File size must be excately 1 MB . ';
				    }
				      
				    if($errors==''){
			    		$val = "problems/" . $fi_name;
			    		unlink($val);
				       	move_uploaded_file($file_tmp,"problems/".$file_name);
				    }
			    }
			    $name = htmlentities($_POST["title"]);
			    $level = htmlentities($_POST["level"]);
			    $pro_id = $_POST["problem_id"];
			    $x = '';
			    if($_POST["Select_test_case"]==0)
			    {

			    	$a = array();
					$p = array();
					$q = array();
			    	array_push($q, base64_encode($_POST['c_0_o_1']));
			    	$a['input_list'] = $p;
					$a['output_list'] = $q;
					$x = json_encode($a);
			    }
			    elseif ($_POST["Select_test_case"]==1) {
			    	$sd = "temp_code/input_files/" . $file_name;
					array_map('unlink', glob("$sd/*.*"));
					rmdir($sd);
			    	$a = array();
					$p = array();
					$q = array();
			    	$v1 = $_POST['c_1_i_1'];
			    	$s0 = "temp_code/input_files/" . $file_name;
			    	mkdir("$s0");
			    	$s1 = $s0 . '/1.txt';
			    	array_push($p, $s1);
			    	array_push($q, base64_encode($_POST['c_1_o_1']));
			    	file_put_contents( "$s1", $v1);
			    	$a['input_list'] = $p;
					$a['output_list'] = $q;
					$x = json_encode($a);
			    }
			    elseif ($_POST["Select_test_case"]==2) {
			    	$sd = "temp_code/input_files/" . $file_name;
					array_map('unlink', glob("$sd/*.*"));
					rmdir($sd);
			    	$a = array();
					$p = array();
					$q = array();
			    	$v1 = $_POST['c_2_i_1'];
			    	$v2 = $_POST['c_2_i_2'];
			    	$s0 = "temp_code/input_files/" . $file_name;
			    	mkdir("$s0");
			    	$s1 = $s0 . '/1.txt';
			    	array_push($p, $s1);
			    	array_push($q, base64_encode($_POST['c_2_o_1']));
			    	$s2 = $s0 . '/2.txt';
			    	array_push($p, $s2);
			    	array_push($q, base64_encode($_POST['c_2_o_2']));
			    	file_put_contents( "$s1", $v1);
			    	file_put_contents( "$s2", $v2);
			    	$a['input_list'] = $p;
					$a['output_list'] = $q;
					$x = json_encode($a);
			    }
			    elseif ($_POST["Select_test_case"]==3) {
			    	$sd = "temp_code/input_files/" . $file_name;
					array_map('unlink', glob("$sd/*.*"));
					rmdir($sd);
			    	$a = array();
					$p = array();
					$q = array();
			    	$v1 = $_POST['c_3_i_1'];
			    	$v2 = $_POST['c_3_i_2'];
			    	$v3 = $_POST['c_3_i_3'];
			    	$s0 = "temp_code/input_files/" . $file_name;
			    	mkdir("$s0");
			    	$s1 = $s0 . '/1.txt';
			    	array_push($p, $s1);
			    	array_push($q, base64_encode($_POST['c_3_o_1']));
			    	$s2 = $s0 . '/2.txt';
			    	array_push($p, $s2);
			    	array_push($q, base64_encode($_POST['c_3_o_2']));
			    	$s3 = $s0 . '/3.txt';
			    	array_push($p, $s3);
			    	array_push($q, base64_encode($_POST['c_3_o_3']));
			    	file_put_contents( "$s1", $v1);
			    	file_put_contents( "$s2", $v2);
			    	file_put_contents( "$s3", $v3);
			    	$a['input_list'] = $p;
					$a['output_list'] = $q;
					$x = json_encode($a);
			    }
			    $query = "UPDATE problems SET ";
		        $query.= "name = '{$name}', ";
		        $query.= "filename = '{$file_name}', ";
		        $query.= "level = '{$level}', ";
		        $query.= "ioinfo = '{$x}' ";
		        $query.= "WHERE id = '{$pro_id}' ";

	            $result=mysqli_query($connection,$query);
	            if ($result) {
	                // Success
	                $_SESSION["message"] .= "Problem edited . ";
	                redirect_to("edit_program.php");
	            } else {
	                // Failure
	                $_SESSION["message"] .= "Problem edit failed . ";
	                redirect_to("edit_program.php");
	            }
			}
			if (isset($_GET['id']))
			{
			    if (isset($_GET['role'])&&$_GET['role']=='edit') {
			    	$problem_id = $_GET['id'];
			    	$sql = "SELECT * FROM problems WHERE id = $problem_id";
			        $query1 = mysqli_query($connection,$sql);
			        $row = $query1->fetch_assoc();
	?>

		            <div class="container" style="margin-bottom: -40px;">
		            	<form class="form-horizontal" role="form" action="edit_program.php" method="post" enctype="multipart/form-data">
						  	<div class="form-group">
							    <label class="control-label col-sm-2" for="title">Title:</label>
							    <div class="col-sm-8">
							      	<input type="text" class="form-control" id="title" placeholder="Enter problem name" name="title" value="<?php echo $row['name']; ?>" required>
							    </div>
						  	</div>
						  	<div class="form-group">
							    <label class="control-label col-sm-2" for="level">Level:</label>
							    <div class="col-sm-8"> 
							      	<input type="text" class="form-control" id="level" placeholder="Problem level" name="level" value="<?php echo $row['level']; ?>" required>
							    </div>
						  	</div>
						  	<div class="form-group">
						  		<label class="control-label col-sm-2" for="pdf">Problem file:</label>
						    	<div class="col-sm-8"> 
						     		<a class='btn btn-default' href='javascript:;'>Select File<input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="pdf" size="40"  onchange='$("#upload-file-info").html($(this).val());'></a>&nbsp;<span class='label label-info' id="upload-file-info"></span>
						    	</div>
						  	</div>
						  	<div class="form-group">
						    	<label class="control-label col-sm-2" for="Select_test_case">Select test case number:</label>
						    	<div class="col-sm-8"> 
						      		<select class="form-control" id="Select_test_case" onchange="select_option(this);" name="Select_test_case">
						        		<option value="select">select</option>
						        		<option value="0">0</option>
						        		<option value="1">1</option>
						        		<option value="2">2</option>
						        		<option value="3">3</option>
						      		</select>
						    	</div>
						  	</div>

						  	<div id="input-0" style="display: none;">
						  		<div class="form-group">
						  			<p style="text-align: center; font-weight: bold">Please give input and output carefully</p>
								    <label class="control-label col-sm-2" for="c_0_o_1">case 1:</label>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_0_o_1" name="c_0_o_1"></textarea>
								    </div>
								</div>
						  	</div>

						  	<div id="input-1" style="display: none;">
						  		<div class="form-group">
						  			<p style="text-align: center; font-weight: bold">Please give input and output carefully</p>
								    <label class="control-label col-sm-2" for="c_1_i_1">case 1:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_1_i_1" name="c_1_i_1"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_1_o_1" name="c_1_o_1"></textarea>
								    </div>
								</div>
						  	</div>
						  	<div id="input-2" style="display: none;">
						  		<div class="form-group">
						  			<p style="text-align: center; font-weight: bold">Please give input and output carefully</p>
								    <label class="control-label col-sm-2" for="c_2_i_1">case 1:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_2_i_1" name="c_2_i_1"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_2_o_1" name="c_2_o_1"></textarea>
								    </div>
								</div>
								<div class="form-group">
								    <label class="control-label col-sm-2" for="c_2_i_2">case 2:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_2_i_2" name="c_2_i_2"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_2_o_2" name="c_2_o_2"></textarea>
								    </div>
								</div>
						  	</div>
						  	<div id="input-3" style="display: none;">
						  		<div class="form-group">
						  			<p style="text-align: center; font-weight: bold">Please give input and output carefully</p>
								    <label class="control-label col-sm-2" for="c_3_i_1">case 1:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_3_i_1" name="c_3_i_1"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_3_o_1" name="c_3_o_1"></textarea>
								    </div>
								</div>
								<div class="form-group">
								    <label class="control-label col-sm-2" for="c_3_i_2">case 2:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_3_i_2" name="c_3_i_2"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_3_o_2" name="c_3_o_2"></textarea>
								    </div>
								</div>
								<div class="form-group">
								    <label class="control-label col-sm-2" for="c_3_i_3">case 3:</label>
								    <div class="col-sm-4">
								    	<br>
								    	<p>Input</p>
								      	<textarea class="form-control" rows="5" id="c_3_i_3" name="c_3_i_3"></textarea>
								    </div>
								    <div class="col-sm-4"> 
								    	<br>
								      	<p>Output</p>
								      	<textarea class="form-control" rows="5" id="c_3_o_3" name="c_3_o_3"></textarea>
								    </div>
								</div>
						  	</div>
						  	<div class="form-group" style="display: none"> 
						    	<div class="col-sm-offset-2 col-sm-10">
						     	 	<input type="text" name="problem_id" value="<?php echo $problem_id; ?>">
						    	</div>
						  	</div>
						  	<div class="form-group"> 
						    	<div class="col-sm-offset-2 col-sm-10">
						     	 	<button type="submit" name="submit" class="btn btn-success">Submit</button>
						    	</div>
						  	</div>
						</form>
		            </div>
	    <?php   }
		        else if (isset($_GET['role'])&&$_GET['role']=='delete') {
		            $v2=$_GET["id"];
			    	$sql = "DELETE FROM problems WHERE id= '{$v2}' ";
			    	$sql1 = "SELECT * FROM problems WHERE id = $v2";
			        $query1 = mysqli_query($connection,$sql1);
			        $row = $query1->fetch_assoc();
			        $file_name = $row['filename'];
			    	$sd = "temp_code/input_files/" . $file_name;
			    	$val = "problems/" . $file_name;
			    	$result=mysqli_query($connection,$sql);
			    	if ($result) {
			    		// Success
			            $_SESSION["message"] = "button deleted";
			  			unlink($val);
			  			array_map('unlink', glob("$sd/*.*"));
						rmdir($sd);
	                    redirect_to("edit_program.php");
			             
			    	} else {
			    		// Failure
			           $_SESSION["message"] = "button deletion failed";
	                    redirect_to("edit_program.php");
			    
			    	}
		        } 
		        else
		        {
		        	redirect_to("edit_program.php");
		        }
			}
			else
			{	?>
				<div class="container" style="margin-bottom: -40px;">
					<?php echo message(); ?>
				    <div class="row">
				        <div class="col-md-12">
				            <div class="panel panel-info">
				                <div class="panel-heading">
				                    <h3 class="panel-title" style="text-align: center;font-size: 15px">SELECT AN ACTION FOR ONE OF THE FOLLOWING PROBLEMS</h3>
				                </div>
				                <ul class="list-group">
				                    <div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;background-color:#eef5e9;padding: 5px 15px;">
				                    	<div class="col-xs-2">ID</div>
				                    	<div class="col-xs-4">Title</div>
				                    	<div class="col-xs-2">Level</div>
				                    	<div class="col-xs-4" style="text-align: center;">Options</div>
				                    </div>
				                    <?php

					                    $query1 = mysqli_query($connection,"SELECT * FROM problems");
										$r_array = array();
										while($row = $query1->fetch_assoc()) {
											array_push($r_array, $row);
									    }
				                    	$i=1;
				                    	foreach ($r_array as $key => $value) {
				                    		echo '<div class="row list-group-item panel-success" style="margin-right: 0px;margin-left: 0px;padding: 5px 15px;">';
					                    		echo '<div class="col-xs-2">'. $i .'</div>';
						                    	echo '<div class="col-xs-4">'. $value['name'] .'</div>';
						                    	echo '<div class="col-xs-2">'. $value['level'] .'</div>';
						                    	echo '<div class="col-xs-2"><a href="edit_program.php?id='. $value['id'] .'&role=edit" style="vertical-align: middle;display: inline-block; padding: 5px 10px;" class="label label-warning"">Edit</a></div>';
						                    	echo '<div class="col-xs-2"><a href="edit_program.php?id='. $value['id'] .'&role=delete" style="vertical-align: middle;display: inline-block; padding: 5px;" class="label label-danger"">Delete</a></div>';
					                    	echo '</div>';
					                    	$i++;
				                    	}
				                    ?>
				                </ul>
				            </div>
				        </div>
				    </div>
				</div>
<?php       }
		}
		else
		{
			redirect_to("home.php");
		}?>
<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>