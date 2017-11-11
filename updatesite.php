<?php
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: admindashboard.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $NameError = null;
    
         
        // keep track post values
        $Name = $_POST['Name'];
     

         
        // validate input
        $valid = true;
        if (empty($Name)) {
            $NameError = 'Please enter Name';
            $valid = false;
        }
       
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE sites  set sname = ? WHERE sid = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($Name,$id));
            Database::disconnect();
            header("Location: admindashboard.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM documents where did = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $Name = $data['dname'];
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
                        <h1>Modifier le site</h1>
                    </div><br>
             <div class="col-xs-4 col-xs-offset-4">
                    <form class="form-horizontal" action="updatesite.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($NameError)?'error':'';?>">
                        <label class="control-label">Tapez le nouveau nom du site </label>
                        <div class="controls">
                            <input Name="Name" type="text"  placeholder="Name" value="<?php echo !empty($Name)?$Name:'';?>">
                            <?php if (!empty($NameError)): ?>
                                <span class="help-inline"><?php echo $NameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div><br>
                      <div class="form-actions"><br>
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="admindashboard.php">Back</a>
                        </div>
                    </form>
                </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>