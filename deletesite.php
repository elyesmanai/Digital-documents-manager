<?php
    require 'database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM sites  WHERE sid = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: admindashboard.php");
         
    }
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
                        <h1>Supprimer le Site</h1>
                    </div>
                     
                    <form  class="form-horizontal" action="deletesite.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <h3 class="alert alert-error">Voulez-vous supprimer ce site?</H3>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="admindashboard.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>