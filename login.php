<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

//establishing connection to Database
$conn = mysqli_connect('localhost','root','', 'ged');
if (!$conn) {
	die("connection failed:".mysqli_connect_error());
}
/*
$sql = "SELECT * FROM members WHERE name='$first'";
$result= $conn -> query($sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = row['code'];
$hash = password_verify($code,$hash_pwd);

if ($hash == 0) {
	header("location: login.php");
	exit();
}
else{*/
$sql = "SELECT * FROM employees WHERE ename='$username'AND epass='$password'";
$result= $conn->query($sql);

if (!$row = mysqli_fetch_assoc($result)) {header("location: index.php?error=wrong");}
	else {$_SESSION['id']=$row['eid'];
		  $_SESSION['name']=$row['ename'];

			if ($_SESSION['id'] == 1) {header("location: admindashboard.php");}
		 		else{ header("location: userdashboard.php");}
		 }

//
//}
?>