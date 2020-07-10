<?php require_once("../session.php"); ?>
<?php require_once("../db_connection.php"); ?>
<?php require_once("../functions.php"); ?>
<?php include '../header.php'; ?>
<?php include '../navbar.php'; ?>
</div>

			<?php 
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    
                    if (isset($_POST['submit'])) {
                        print_r($_POST);
                        //if(isset($_FILES['select_code_file'])){
                            //echo "<br>";
                            //echo $_FILES['select_code_file']['name'];
                        //}
                        $code_file_name_final = '';
                        if ($_POST['code_submit_option']=='code') {
                            $code = $_POST['code_text'];
                            $vx = $_SESSION['username'] . $_POST['problem_id'] .  '.cpp';
                            file_put_contents( $vx, $code );
                            $code_file_name_final = $_SESSION['username'] . $_POST['problem_id'] .  '.cpp';
                        }
                        elseif ($_POST['code_submit_option']=='file') {
                            if(isset($_FILES['select_code_file'])){
                                $errors= '';
                                $vx = $_SESSION['username'] . $_POST['problem_id'] .  '.cpp';
                                $file_name = $_FILES['select_code_file']['name'];
                                $file_size =$_FILES['select_code_file']['size'];
                                $file_tmp =$_FILES['select_code_file']['tmp_name'];
                                $file_type=$_FILES['select_code_file']['type'];
                                $file_ext=strtolower($file_name);
                                $v = explode('.',$file_ext);
                                $file_ext=end($v);
                                  
                                $expensions= array("c","cpp");
                                  
                                if(in_array($file_ext,$expensions)=== false){
                                   $errors .= "extension not allowed, please choose a PDF file . ";
                                   $_SESSION["message"].= "extension not allowed, please choose a c or cpp file.<br>";
                                }
                                  
                                if($file_size > 1048576){
                                   $errors.='File size must be excately 1 MB.<br>';
                                   $_SESSION["message"].= 'File size must be excately 1 MB . ';
                                }
                                  
                                if($errors==''){
                                    move_uploaded_file($file_tmp,$vx);
                                    $code_file_name_final = $vx;
                                }
                            }
                        }
                        $exe_file = exec_file_name($code_file_name_final);
                        $command = 'g++ '. $code_file_name_final . '  -o ' . $exe_file . '.exe 2>&1';
                        exec($command, $out);
                        $res_problem = 1;
                        if($out == false)
                        {
                            $xx = $_POST['problem_id'];
                            $sql = "SELECT * FROM problems WHERE id = $xx";
                            $query2 = mysqli_query($connection,$sql);
                            $row = $query2->fetch_assoc();
                            $in_and_out = json_decode( $row['ioinfo'], true);
                            if (count($in_and_out['input_list'])==0) {
                                $s_out = base64_decode($in_and_out['output_list'][0]);
                                $timeout_in_sec = 4;
                                $cmd =  $exe_file .'.exe';
                                $out1 = execute($cmd, $timeout_in_sec);
                                if ($out1[0]=='T' && $out1[1]=='I' && $out1[2]=='M' && $out1[3]=='E' && $out1[4]=='_') {
                                    $res_problem = -1;
                                }
                                elseif (strcmp($out1, $s_out) !== 0) {
                                    $res_problem = 0;
                                }
                            }
                            elseif (count($in_and_out['input_list'])==1) {
                                $s_out = base64_decode($in_and_out['output_list'][0]);
                                $timeout_in_sec = 4;
                                $xoxo = str_replace("temp_code/", "", $in_and_out['input_list'][0]);//
                                $cmd =  $exe_file .'.exe < '. $xoxo;//
                                $out1 = execute($cmd, $timeout_in_sec);
                                if ($out1[0]=='T' && $out1[1]=='I' && $out1[2]=='M' && $out1[3]=='E' && $out1[4]=='_') {
                                    $res_problem = -1;
                                }
                                elseif (strcmp($out1, $s_out) !== 0) {
                                    $res_problem = 0;
                                }
                            }
                            elseif (count($in_and_out['input_list'])==2) {
                                $s_out1 = base64_decode($in_and_out['output_list'][0]);
                                $s_out2 = base64_decode($in_and_out['output_list'][1]);
                                $xoxo1 = str_replace("temp_code/", "", $in_and_out['input_list'][0]);
                                $xoxo2 = str_replace("temp_code/", "", $in_and_out['input_list'][1]);
                                $timeout_in_sec = 4;
                                $cmd =  $exe_file .'.exe < '. $xoxo1;//
                                $out1 = execute($cmd, $timeout_in_sec);
                                $cmd =  $exe_file .'.exe < '. $xoxo2;//
                                $out2 = execute($cmd, $timeout_in_sec);
                                if ($out1[0]=='T' && $out1[1]=='I' && $out1[2]=='M' && $out1[3]=='E' && $out1[4]=='_') {
                                    $res_problem = -1;
                                }
                                elseif (strcmp($out1, $s_out1) !== 0) {
                                    $res_problem = 0;
                                }
                                elseif (strcmp($out2, $s_out2) !== 0) {
                                    $res_problem = 0;
                                }
                            }
                            elseif (count($in_and_out['input_list'])==3) {
                                $s_out1 = base64_decode($in_and_out['output_list'][0]);
                                $s_out2 = base64_decode($in_and_out['output_list'][1]);
                                $s_out3 = base64_decode($in_and_out['output_list'][2]);
                                $xoxo1 = str_replace("temp_code/", "", $in_and_out['input_list'][0]);
                                $xoxo2 = str_replace("temp_code/", "", $in_and_out['input_list'][1]);
                                $xoxo3 = str_replace("temp_code/", "", $in_and_out['input_list'][2]);
                                $timeout_in_sec = 4;
                                $cmd =  $exe_file .'.exe < '. $xoxo1;//
                                $out1 = execute($cmd, $timeout_in_sec);
                                $cmd =  $exe_file .'.exe < '. $xoxo2;//
                                $out2 = execute($cmd, $timeout_in_sec);
                                $cmd =  $exe_file .'.exe < '. $xoxo3;//
                                $out3 = execute($cmd, $timeout_in_sec);
                                if ($out1[0]=='T' && $out1[1]=='I' && $out1[2]=='M' && $out1[3]=='E' && $out1[4]=='_') {
                                    $res_problem = -1;
                                }
                                elseif (strcmp($out1, $s_out1) !== 0) {
                                    $res_problem = 0;
                                }
                                elseif (strcmp($out2, $s_out2) !== 0) {
                                    $res_problem = 0;
                                }
                                elseif (strcmp($out3, $s_out3) !== 0) {
                                    $res_problem = 0;
                                }
                            }
                            $exe_file = $exe_file . '.exe';
                            unlink($exe_file);
                        }
                        else
                        {
                            $res_problem = -2;
                        }
                        unlink($code_file_name_final);
                        if ($res_problem==1) {
                            $_SESSION['message'] = 'Solution accepted';
                            $problemid = $_GET['id'];
                            $sql = "SELECT * FROM problems WHERE id = $problemid";
                            $query1 = mysqli_query($connection,$sql);
                            $row = $query1->fetch_assoc();
                            $pre_sub_info = $row['subinfo'];
                            $pre_sub_info = json_decode($pre_sub_info, true);
                            if (array_search($_SESSION['username'],$pre_sub_info['solved'])==false) {
                                array_push($pre_sub_info['solved'], $_SESSION['username']); 
                            }
                            if (array_search($_SESSION['username'],$pre_sub_info['submitted'])==false) {
                                array_push($pre_sub_info['submitted'], $_SESSION['username']); 
                            }
                            $x1 = json_encode($pre_sub_info);
                            $query = "UPDATE problems SET ";
                            $query.= "subinfo = '{$x1}' ";
                            $query.= "WHERE id = '{$problemid}' ";
                            $result=mysqli_query($connection,$query);

                            $unm = $_SESSION['userid'];
                            $sql5 = "SELECT * FROM admins WHERE id = $unm";
                            $query5 = mysqli_query($connection,$sql5);
                            $row5 = $query5->fetch_assoc();
                            $acc_prob = $row5['accepted'];
                            $sub_prob = $row5['submitted'];
                            $subinfo_prob = $row5['subinfo'];
                            $sub_prob  = $sub_prob + 1;
                            $subinfo_prob = json_decode($subinfo_prob, true);
                            if (array_search($problemid,$subinfo_prob['acc_list'])===false) {
                                array_push($subinfo_prob['acc_list'], $problemid);
                                $acc_prob = $acc_prob + 1;
                            }
                            if (array_search($problemid , $subinfo_prob['sub_list'])===false) {
                                array_push($subinfo_prob['sub_list'], $problemid);
                            }
                            $x11 = json_encode($subinfo_prob);
                            $query = "UPDATE admins SET ";
                            $query.= "subinfo = '{$x11}', ";
                            $query.= "accepted = '{$acc_prob}', ";
                            $query.= "submitted = '{$sub_prob}' ";
                            $query.= "WHERE id = '{$unm}' ";
                            $result=mysqli_query($connection,$query);
                            //change problems subinfo change admins accepted submitted subinfo
                            redirect_to("http://localhost/oj/problems.php");

                        }
                        elseif ($res_problem==0) {
                            $_SESSION['message'] = 'Wrong answer';
                            $problemid = $_GET['id'];
                            $sql = "SELECT * FROM problems WHERE id = $problemid";
                            $query1 = mysqli_query($connection,$sql);
                            $row = $query1->fetch_assoc();
                            $pre_sub_info = $row['subinfo'];
                            $pre_sub_info = json_decode($pre_sub_info, true);
                            if (array_search($_SESSION['username'],$pre_sub_info['submitted'])==false) {
                                array_push($pre_sub_info['submitted'], $_SESSION['username']); 
                            }
                            $x1 = json_encode($pre_sub_info);
                            $query = "UPDATE problems SET ";
                            $query.= "subinfo = '{$x1}' ";
                            $query.= "WHERE id = '{$problemid}' ";
                            $result=mysqli_query($connection,$query);

                            $unm = $_SESSION['userid'];
                            $sql5 = "SELECT * FROM admins WHERE id = $unm";
                            $query5 = mysqli_query($connection,$sql5);
                            $row5 = $query5->fetch_assoc();
                            $acc_prob = $row5['accepted'];
                            $sub_prob = $row5['submitted'];
                            $subinfo_prob = $row5['subinfo'];
                            $sub_prob  = $sub_prob + 1;
                            $subinfo_prob = json_decode($subinfo_prob, true);
                            if (array_search($problemid , $subinfo_prob['sub_list'])===false)
                            {
                                array_push($subinfo_prob['sub_list'], $problemid);
                            }
                            $x11 = json_encode($subinfo_prob);
                            $query = "UPDATE admins SET ";
                            $query.= "subinfo = '{$x11}', ";
                            $query.= "accepted = '{$acc_prob}', ";
                            $query.= "submitted = '{$sub_prob}' ";
                            $query.= "WHERE id = '{$unm}' ";
                            $result=mysqli_query($connection,$query);
                            redirect_to("http://localhost/oj/problems.php");
                        }
                        elseif ($res_problem==-1) {
                            $_SESSION['message'] = 'Time limit extended';
                            $problemid = $_GET['id'];
                            $sql = "SELECT * FROM problems WHERE id = $problemid";
                            $query1 = mysqli_query($connection,$sql);
                            $row = $query1->fetch_assoc();
                            $pre_sub_info = $row['subinfo'];
                            $pre_sub_info = json_decode($pre_sub_info, true);
                            if (array_search($_SESSION['username'],$pre_sub_info['submitted'])==false) {
                                array_push($pre_sub_info['submitted'], $_SESSION['username']); 
                            }
                            $x1 = json_encode($pre_sub_info);
                            $query = "UPDATE problems SET ";
                            $query.= "subinfo = '{$x1}' ";
                            $query.= "WHERE id = '{$problemid}' ";
                            $result=mysqli_query($connection,$query);

                            $unm = $_SESSION['userid'];
                            $sql5 = "SELECT * FROM admins WHERE id = $unm";
                            $query5 = mysqli_query($connection,$sql5);
                            $row5 = $query5->fetch_assoc();
                            $acc_prob = $row5['accepted'];
                            $sub_prob = $row5['submitted'];
                            $subinfo_prob = $row5['subinfo'];
                            $sub_prob  = $sub_prob + 1;
                            $subinfo_prob = json_decode($subinfo_prob, true);
                            if (array_search($problemid , $subinfo_prob['sub_list'])===false) {
                                array_push($subinfo_prob['sub_list'], $problemid);
                            }
                            $x11 = json_encode($subinfo_prob);
                            $query = "UPDATE admins SET ";
                            $query.= "subinfo = '{$x11}', ";
                            $query.= "accepted = '{$acc_prob}', ";
                            $query.= "submitted = '{$sub_prob}' ";
                            $query.= "WHERE id = '{$unm}' ";
                            $result=mysqli_query($connection,$query);
                            redirect_to("http://localhost/oj/problems.php");
                        }
                        elseif ($res_problem==-2) {
                            $_SESSION['message'] = 'Syntex error';
                            $problemid = $_GET['id'];
                            $sql = "SELECT * FROM problems WHERE id = $problemid";
                            $query1 = mysqli_query($connection,$sql);
                            $row = $query1->fetch_assoc();
                            $pre_sub_info = $row['subinfo'];
                            $pre_sub_info = json_decode($pre_sub_info, true);
                            if (array_search($_SESSION['username'],$pre_sub_info['submitted'])==false) {
                                array_push($pre_sub_info['submitted'], $_SESSION['username']); 
                            }
                            $x1 = json_encode($pre_sub_info);
                            $query = "UPDATE problems SET ";
                            $query.= "subinfo = '{$x1}' ";
                            $query.= "WHERE id = '{$problemid}' ";
                            $result=mysqli_query($connection,$query);

                            $unm = $_SESSION['userid'];
                            $sql5 = "SELECT * FROM admins WHERE id = $unm";
                            $query5 = mysqli_query($connection,$sql5);
                            $row5 = $query5->fetch_assoc();
                            $acc_prob = $row5['accepted'];
                            $sub_prob = $row5['submitted'];
                            $subinfo_prob = $row5['subinfo'];
                            $sub_prob  = $sub_prob + 1;
                            $subinfo_prob = json_decode($subinfo_prob, true);
                            if (array_search($problemid , $subinfo_prob['sub_list'])===false) {
                                array_push($subinfo_prob['sub_list'], $problemid);
                            }
                            $x11 = json_encode($subinfo_prob);
                            $query = "UPDATE admins SET ";
                            $query.= "subinfo = '{$x11}', ";
                            $query.= "accepted = '{$acc_prob}', ";
                            $query.= "submitted = '{$sub_prob}' ";
                            $query.= "WHERE id = '{$unm}' ";
                            $result=mysqli_query($connection,$query);
                            redirect_to("http://localhost/oj/problems.php");

                        }
                    }
                    else{

                    $problemid = $_GET['id'];
                    $sql = "SELECT * FROM problems WHERE id = $problemid";
                    $query1 = mysqli_query($connection,$sql);
                    $row = $query1->fetch_assoc();
            ?>
                    <div class="container">
                        <form class="form-horizontal" role="form" action="http://localhost/oj/temp_code/submit.php?id=<?php echo $problemid; ?>" method="post" enctype="multipart/form-data">
                            <div class="row" style="padding-bottom: 30px;">
                                <div class="col-xs-4">Problem
                                    <select class="form-control" name="problem_id">
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    </select>
                                </div>
                                <div class="col-xs-4">Select language
                                    <select class="form-control">
                                        <option>C</option>
                                        <option>C++</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">Option
                                    <select class="form-control" id="code_submit_option" onchange="select_code_submit_option(this);" name="code_submit_option">
                                        <option value="select">Select</option>
                                        <option value="code">Submit Code</option>
                                        <option value="file">Submit file</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" id="code_editor" style="display: none;">
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Paste your code</label>
                                    <div class="col-sm-8"> 
                                        <textarea class="form-control" rows="10" id="code_text" name="code_text" style="height: 300px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group" id="select_code_file" style="display: none;">
                                <label class="control-label col-sm-2" for="select_code_file" style="padding-left: 0px;">Upload file:</label>
                                <div class="col-sm-10"> 
                                    <a class='btn btn-default' href='javascript:;'>Select File<input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="select_code_file" size="40"  onchange='$("#upload-file-info").html($(this).val());'></a>&nbsp;<span class='label label-info' id="upload-file-info"></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <button class="btn btn-success" type="submit" name="submit" onclick="sent_code();">Submit</button>
                        </form>
                    </div>
    <?php
            }
        }
            else{
                    redirect_to("http://localhost/oj/problems.php");
                }
            ?>
         


<?php include '../footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>