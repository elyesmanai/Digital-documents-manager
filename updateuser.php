<?php
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: userdashboard.php");
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
            $sql = "UPDATE documents  set dname = ?, dsite = ? WHERE did = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($Name,$site,$id));
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
                        <h1>Modifier Utilisateur</h1>
                    </div>
             
                    <form class="form-horizontal" action="updateuser.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($NameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input Name="Name" type="text"  placeholder="Name" value="<?php echo !empty($Name)?$Name:'';?>">
                            <?php if (!empty($NameError)): ?>
                                <span class="help-inline"><?php echo $NameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($siteError)?'error':'';?>">
                        <label class="control-label">site</label>
                        <div class="controls">
                            <input Name="site" type="text" placeholder="site "" value="<?php echo !empty($site)?$site:'';?>">
                            <?php if (!empty($siteError)): ?>
                                <span class="help-inline"><?php echo $siteError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="userdashboard.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>