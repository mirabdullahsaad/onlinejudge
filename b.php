<?php require_once("db_connection.php"); ?>
<?php require_once("session.php"); ?>
<?php
$x11='pppppp';
$acc_prob=55;
$sub_prob=55;
$unm = 11;
$query = "UPDATE admins SET subinfo = '{$x11}', accepted = '{$acc_prob}', submitted = '{$sub_prob}' WHERE id = '{$unm}'";
$result=mysqli_query($connection,$query);
//$row = $result->fetch_assoc();
//$x = $row['ioinfo'];
//$my_array = json_decode( $x, true);
//echo count($my_array['input_list']);
//$data = json_decode($foo, TRUE);
echo "<pre>";
var_dump($result);	
echo "</pre>";
?>