<?php
     session_start();
    require 'database.php';
    $id = $_GET['id'];

    if (isset($_POST['sites']) ) {
    $s= $_POST['sites'];
       
        $pdo = Database::connect();   
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            $N = count($s);
            for($i=0; $i < $N; $i++)
            {
            $sql = "INSERT IGNORE INTO appartient (aempid,asite) VALUES (?,?)";  
            $q = $pdo->prepare($sql);
            $q->execute(array($id,$s[$i]));
            }
             Database::disconnect();
  
    }
    if (isset($_POST['deja'])) {
       $d= $_POST['deja'];

           $pdo = Database::connect();   
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            $N = count($d);
            for($i=0; $i < $N; $i++)
            {
            $sql = "DELETE FROM appartient WHERE aempid = ? AND asite= ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id,$d[$i]));
            }
             Database::disconnect();
    }
    
   


   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body style="background-color: #C4CDCD">
 <br><br><br><br><br><br><br><br><br> <div class="container" align="center">

                <div class="span10 offset1">
                <?php echo '<form  action="acces.php?id='.$id.'" method="POST">';?>
                    <div class="row">
                        <div class="col-sm-6">
                        <h2>enlever à l'employé l'accès aux sites suivants:</h2><br>

                        <?php
                               $pdo = Database::connect();
                               $sql = "SELECT * FROM appartient WHERE aempid='$id' ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<input type="checkbox" name="deja[]" value="'.$row['asite'].'"> '.$row['asite'].'<br>';
                                        $app[] = $row['asite'];
                               }
                               Database::disconnect();
                               $app[]=1;
                               
                               if (count($app)==1) {
                               echo "l'employé n'appartient à aucun site";}
                        ?>
                        <br><br>
                        </div>
                        <div class="col-sm-6">
                        <h2>Donner à l'employé l'accès aux sites suivants:</h2><br>

                        <?php
                               $pdo = Database::connect();
                               $sql = "SELECT * FROM sites";
                               foreach ($pdo->query($sql) as $row) {
                                $ap[] =$row['sname'] ;
                              }
                              Database::disconnect();
                              $nbr=count($ap);
                              
                              foreach ($ap as &$key) {
                                foreach ($app as $key1) {
                                  if ($key == $key1) {
                                    $key=0;
                                  }
                                }
                              }
                              for ($i=0; $i <count($ap) ; $i++) { 
                                if (!$ap[$i]==0) {
                                 echo '<input type="checkbox" name="sites[]" value="'.$ap[$i].'"> '.$ap[$i].'<br>';}
                                
                              }

                                if ($nbr==count($app)) {
                                   echo "l'employé appartient à tous les sites"; 
                                }
                               
                               echo '<input type="hidden" name="id" value="'.$id.'">';
                        ?>      
                        </div>
                    </div><br>
                         <br><br>
                        <button type="submit" class="btn btn-success">Ajouter</button>

                    </form>
                    <br>    <a href="admindashboard.php"><button  class="btn btn-success">Retour</button>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
        