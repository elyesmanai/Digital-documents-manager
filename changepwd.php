<?php
session_start();
$id = $_SESSION['id'];
$old = $_POST['oldpassword'];
$new = $_POST['newpassword'];

if ($id==1) {
               if ($old == '' or $new =='') {
	header("location: admindashboard.php?error=pwdempty");
	exit();}
else{
		//establishing connction to the database
		$conn = mysqli_connect('localhost','root','', 'ged');
		if (!$conn) {die("connection failed:".mysqli_connect_error());}

		//checking if the name already exists
		$sql= "SELECT epass FROM employees WHERE epass='$old' AND eid='$id'";
		$result= $conn -> query($sql);
		$pwdcheck = mysqli_num_rows($result);
		if ($pwdcheck != 1) {
			header("location: admindashboard.php?error=pwdwrg");
			mysqli_close($conn);
			exit();}
		else{
			$sql= "UPDATE employees SET epass='$new' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: admindashboard.php?success");
		}
	}

} 
else{ if ($old == '' or $new =='') {
	header("location: userdashboard.php?error=pwdempty");
	exit();}
	else{
		//establishing connction to the database
		$conn = mysqli_connect('localhost','root','', 'ged');
		if (!$conn) {die("connection failed:".mysqli_connect_error());}

		//checking if the name already exists
		$sql= "SELECT epass FROM employees WHERE epass='$old' AND eid='$id'";
		$result= $conn -> query($sql);
		$pwdcheck = mysqli_num_rows($result);
		if ($pwdcheck != 1) {
			header("location: userdashboard.php?error=pwdwrg");
			mysqli_close($conn);
			exit();}
		else{
			$sql= "UPDATE employees SET epass='$new' WHERE eid='$id'";
			$result= $conn -> query($sql);
			mysqli_close($conn);
			header("location: userdashboard.php?success");
		}
	}}
           
//if any of these fuckers are empty , i'll know it



?>