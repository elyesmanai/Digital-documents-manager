<?php
    require 'database.php';

     $nom=$_GET['n'];
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    $act="supprimé";
    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s");  

         $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM documents WHERE did='$id'";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
         $row=$q->fetch(PDO::FETCH_ASSOC);
        $Name= $row["dname"];
         $site= $row["dsite"];



    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
        $sql = "INSERT INTO log (logemp,logaction,logdoc,logsite,logdate) values(?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nom,$act,$Name,$site,$today));

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM documents  WHERE did = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
      if ($id==1) {
                header("Location: admindashboard.php");
            } else{ header("Location: userdashboard.php");}
           
         
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
                        <h1>Supprimer le document</h1>
                    </div>
                     
                    <form  class="form-horizontal" action="deletedoc.php?id=<?php echo $id ?>&n=<?php echo $nom ?>" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <h3 class="alert alert-error">Voulez-vous supprimer ce document?</H3>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="admindashboard.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>