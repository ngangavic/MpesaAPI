<?php
//this file connects to the Mysql database.

$host="localhost";
$uname="root";
$dbname="mpesatest";
$password="";

//mysqli connection
$conn=mysqli_connect($host,$uname,$password,$dbname);

//pdo connection
$pdo = new PDO("mysql:host=".$host.";dbname=".$dbname,$uname, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

