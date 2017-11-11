<?php
  session_start();
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <br><br><br><br><br><br><br><br><br> <div class="container" align="center">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update successful</h3> <br><br>
                    </div>
                    <div class="row">
                    <div class="col-sm-offset-3 col-sm-3">
                        <?php 
                             echo '<a class="btn btn-success" href="ajouterdoc.php">Ajouter un autre document</a>';
                        ?>
                    </div>
                    <div class="col-sm-3">
                    <?php
                         if ($id==1) {
                             echo "<a class='btn btn-success'  href='admindashboard.php'> Retourner à l'Acceuil</a>";
                         }
                         else{    echo "<a class='btn btn-success'  href='userdashboard.php'> Retourner à l'Acceuil</a>";}
                    ?>
                    </div>
                    </div>
             
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
        