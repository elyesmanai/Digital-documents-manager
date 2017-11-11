<?php
    session_start();
    require 'database.php';
    $id1=$_SESSION['id'];
    $nom=$_GET['n'];
   
   

    $id = null;
    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s");  
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
     if (isset($_POST['quarantine'])) {
    $a="quarantaine";
       $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE documents  set detat = ?  WHERE did = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($a ,$id)); 
            Database::disconnect();
   }

     
    if ( !empty($_POST)) {
        // keep track validation errors
        $NameError = null;
        $siteError = null;
         
        // keep track post values
        $Name = $_POST['Name'];
        $site = $_POST['site'];




         
        // validate input
        $valid = true;
        if (empty($Name)) {
            $NameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($site)) {
            $siteError = 'Please enter site Address';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $act = "modifié";
            $sql = "INSERT INTO log (logemp,logaction,logdoc,logsite,logdate) values(?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nom,$act,$Name,$site,$today));



            $sql = "UPDATE documents  set dname = ?, dsite = ? WHERE did = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($Name,$site,$id));
            Database::disconnect();
            if ($id1==1) {
                header("Location: admindashboard.php");
            } else{ header("Location: userdashboard.php");}
           
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM documents where did = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $Nom = $data['dname'];
        $Name = pathinfo($Nom, PATHINFO_FILENAME);
        $site = $data['dsite'];
        Database::disconnect();
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
                        <h3>Update a document</h3>
                    </div>
                    <div class="col-xs-4 col-xs-offset-4 ">
                        <form class="form-horizontal" action="updatedoc.php?id=<?php echo $id?>&n=<?php echo $nom?>&b=1" method="post">
                          <div class="control-group <?php echo !empty($NameError)?'error':'';?>">
                            <label class="control-label">Name</label>
                            <div class="controls"><br>
                                <input Name="Name" type="text"  placeholder="Name" value="<?php echo !empty($Name)?$Name:'';?>">
                                <?php if (!empty($NameError)): ?>
                                    <span class="help-inline"><?php echo $NameError;?></span>
                                <?php endif; ?>
                            </div>
                          </div>

                           <div><br>
                        <label class="control-label">Choisissez le nouveau site du document</label>
                        <div class="controls"><br>
                            <SELECT name="site" size="1">
                            <?php
                                $pdo = Database::connect();
                               $sql = "SELECT * FROM sites ORDER BY sid DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<option>';
                                        echo  $row['sname'];
                                        echo '</option>';
                                        }

                               Database::disconnect();
                            echo " </SELECT>
                        </div>
                      </div>";
                            ?>

                           <br><br>
                                <input type="checkbox" name="quarantine" value="quarantine">Mettre ce document en attente jusqu'à ce que vous décidez du changement à faire<br>
                          <div class="form-actions"><br>
                              <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form><br><br>
                        <?php 
                         if ($id1==1) {echo '<a href="admindashboard.php" ><button  class="btn btn-success"> Back </button></a>';}
                         else{echo '<a href="userdashboard.php" ><button  class="btn btn-success"> Back </button></a>';}
                        ?>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>