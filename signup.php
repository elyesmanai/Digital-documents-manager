<?php
session_start();
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['confirm-password'];

//if any of these fuckers are empty , i'll know it
if (empty($username)) {
	header("location: index.php?error=empty");
	exit();}
if (empty($email)) {
	header("location: index.php?error=empty");
	exit();}
if (empty($password)) {
	header("location: index.php?error=empty");
	exit();}
if ($password != $cpassword) {
	header("location: index.php?error=notequal");
	exit();}


//establishing connction to the database
$conn = mysqli_connect('localhost','root','', 'ged');
if (!$conn) {die("connection failed:".mysqli_connect_error());}

//checking if the name already exists
$sql= "SELECT ename FROM employees WHERE ename='$username'";
$result= $conn -> query($sql);
$namecheck = mysqli_num_rows($result);
if ($namecheck > 0) {
	header("location: index.php?error=exist");
	exit();
}

//Hashing the password
//$epwd = password_hash($code, PASSWORD_DEFAULT);

$sql = "INSERT INTO employees (ename, eemail, epass) 
VALUES ('$username', '$email', '$password')";
if (mysqli_query($conn, $sql)) {header("location: index.php?error=success");}
 else {echo "Error: " . $sql . "<br>" . mysqli_error($conn);}

mysqli_close($conn);
?>