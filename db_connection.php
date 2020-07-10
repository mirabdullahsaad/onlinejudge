<?php
//1.create database connection
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "123456");
define("DB_NAME", "onlinejudge");

$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
//test the connection
if(mysqli_connect_errno())
{
    die("Database connection failed: ".
        mysqli_connect_error().
        " (" . mysqli_connect_errno() . ")"

       );
}


?>
