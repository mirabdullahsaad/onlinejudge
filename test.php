<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php require_once("functions.php"); ?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
</div>
<?php
    $res_problem = 1;
    $exe_file = "saad";
	$xx = 4;
    $sql = "SELECT * FROM problems WHERE id = $xx";
    $query2 = mysqli_query($connection,$sql);
    $row = $query2->fetch_assoc();
    $in_and_out = json_decode( $row['ioinfo'], true);
    $s_out = base64_decode($in_and_out['output_list'][0]);
    $timeout_in_sec = 4;
    $cmd =   $exe_file .'.exe < '. $in_and_out['input_list'][0];//

    $out1 = execute($cmd, $timeout_in_sec);//
    if ($out1[0]=='T' && $out1[1]=='I' && $out1[2]=='M' && $out1[3]=='E' && $out1[4]=='_') {
        $res_problem = -1;
    }
    elseif (strcmp($out1, $s_out) !== 0) {
        $res_problem = 0;
    }
    var_dump($out1);
    echo "<br>";
    var_dump($cmd);
    echo "<br>";
    var_dump($s_out);
    echo "<br>";
    var_dump($res_problem);
?>


<?php include 'footer.php'; ?>
<?php
//5.close database
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>