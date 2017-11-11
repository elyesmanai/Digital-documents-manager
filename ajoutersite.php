<?php
     session_start();
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
         
        // keep track post values
        $name = $_POST['name'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO sites (sname) values(?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name));
            Database::disconnect();
            header("Location: admindashboard.php");
        }
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
                        <h3>Ajouter un site</h3><br>
                    </div>
                <div class="col-xs-4 col-xs-offset-4">
                    <form class="form-horizontal" action="ajoutersite.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls"><br>
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="form-actions"><br>
                          <button type="submit" class="btn btn-success">Créer Site</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
        