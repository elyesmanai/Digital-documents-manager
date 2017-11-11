<?php
$id = $_GET['id'];
$a='refused';
include 'database.php';
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE documents  set detat = ?  WHERE did = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($a ,$id)); 
            Database::disconnect();
            header("Location: admindashboard.php");
?>