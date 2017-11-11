<?php
include 'Database.php';
session_start();
$id= $_SESSION['id'];
$id1=$_GET['id'];
$a = "approved";
  $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE documents  set detat = ?  WHERE did = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($a ,$id1)); 
            Database::disconnect();
            if ($id==1) {
                header("Location: admindashboard.php");
            } else{ header("Location: userdashboard.php");}
           
?>