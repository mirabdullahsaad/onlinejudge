<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>
<div class="container">
	
	<?php
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['privilage'] < 9)
		{
			if (isset($_POST['submit'])){
				$_SESSION["message"]= '';
				$file_name = '';
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
				       move_uploaded_file($file_tmp,"problems/".$file_name);
				    }
			    }
			    $name = htmlentities($_POST["title"]);
			    $level = htmlentities($_POST["level"]);
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
			    $sub_info = '{"solved":[],"submitted":[]}';
			    $query = "INSERT INTO problems (";
	            $query.= " name, filename, level, subinfo, ioinfo";
	            $query.= ") VALUES (";
	            $query.= "  '{$name}', '{$file_name}', '{$level}', '{$sub_info}', '{$x}'";
	            $query.= ")";
	            $result=mysqli_query($connection,$query);
	            if ($result) {
	                // Success
	                $_SESSION["message"] .= "Problem created . ";
	                redirect_to("problems.php");
	            } else {
	                // Failure
	                $_SESSION["message"] .= "Problem creation failed . ";
	                redirect_to("add_new_program.php");
	            }

			}
			
	?>		
			<div style="text-align: center;">
			    <?php echo message(); ?>
			</div>
			<form class="form-horizontal" role="form" action="add_new_program.php" method="post" enctype="multipart/form-data">
			  	<div class="form-group">
				    <label class="control-label col-sm-2" for="title">Title:</label>
				    <div class="col-sm-8">
				      	<input type="text" class="form-control" id="title" placeholder="Enter problem name" name="title" value="" required>
				    </div>
			  	</div>
			  	<div class="form-group">
				    <label class="control-label col-sm-2" for="level">Level:</label>
				    <div class="col-sm-8"> 
				      	<input type="text" class="form-control" id="level" placeholder="Problem level" name="level" value="" required>
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
			  	<div class="form-group"> 
			    	<div class="col-sm-offset-2 col-sm-10">
			     	 	<button type="submit" name="submit" class="btn btn-success">Submit</button>
			    	</div>
			  	</div>
			</form>
		<?php 
		} else
		{
			redirect_to("home.php");
		}

	?>

</div>
<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>