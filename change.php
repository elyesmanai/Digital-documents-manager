<?php
session_start();
$id = $_SESSION['id'];
$name = $_POST['username'];
$mail = $_POST['email'];
$password = $_POST['password'];

if ($i == 1) {
	
if (empty($password)) {
		header("location: admindashboard.php?error=pwd1empty");
		exit();
}

if (empty($name) and empty($mail)) {
	header("location: admindashboard.php?error=infoempty");
	exit();
}

//establishing connction to the database
$conn = mysqli_connect('localhost','root','', 'ged');
if (!$conn) {die("connection failed:".mysqli_connect_error());}
//checking if the name already exists
$sql= "SELECT epass FROM employees WHERE epass='$password' AND eid='$id'";
$result= $conn -> query($sql);
$pwdcheck = mysqli_num_rows($result);
if ($pwdcheck != 1) {
	header("location: admindashboard.php?error=pwd1wrg");
	mysqli_close($conn);
	exit();
}

if (empty($mail) and !empty($name)) {
	$sql= "UPDATE employees SET ename='$name' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: admindashboard.php?success1");
}
if (empty($name) and !empty($mail)) {
	$sql= "UPDATE employees SET eemail='$mail' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: admindashboard.php?success2");
}
if (!empty($name) and !empty($mail)) {
	$sql= "UPDATE employees SET eemail='$mail', ename='$name' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: admindashboard.php?success2");
}
}
} else {

if (empty($password)) {
		header("location: userdashboard.php?error=pwd1empty");
		exit();
}

if (empty($name) and empty($mail)) {
	header("location: userdashboard.php?error=infoempty");
	exit();
}

//establishing connction to the database
$conn = mysqli_connect('localhost','root','', 'ged');
if (!$conn) {die("connection failed:".mysqli_connect_error());}
//checking if the name already exists
$sql= "SELECT epass FROM employees WHERE epass='$password' AND eid='$id'";
$result= $conn -> query($sql);
$pwdcheck = mysqli_num_rows($result);
if ($pwdcheck != 1) {
	header("location: userdashboard.php?error=pwd1wrg");
	mysqli_close($conn);
	exit();
}

if (empty($mail) and !empty($name)) {
	$sql= "UPDATE employees SET ename='$name' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: userdashboard.php?success1");
}
if (empty($name) and !empty($mail)) {
	$sql= "UPDATE employees SET eemail='$mail' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: userdashboard.php?success2");
}
if (!empty($name) and !empty($mail)) {
	$sql= "UPDATE employees SET eemail='$mail', ename='$name' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: userdashboard.php?success2");
}
}

?>