<?php
        $name= $_GET['name'];
        header('Content-type: application/msword');
        header("Content-Disposition: attachment; filename='$name'");
        readfile($name); 
?>