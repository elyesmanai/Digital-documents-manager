<?php
     session_start();
    require 'database.php';
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $id = $_SESSION['id'];
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
                    <div class="row">
                        <h1>Ajouter un Document</h1><br>
                    </div>
                    <form class="form-horizontal" action="upload.php" method="post" enctype="multipart/form-data">
                      <div>
                        <label class="control-label">Choisissez le site du document</label>
                        <div class="controls"><br>
                            <SELECT name="site" size="1">
                            <?php
                            
                                $pdo = Database::connect();
                               $sql = "SELECT * FROM appartient WHERE aempid ='$id' ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<option>';
                                        echo  $row['asite'];
                                        echo '</option>';
                                        $e[] = $row['asite'];
                               }
                               Database::disconnect();
                               echo "</SELECT></div></div><br>";
                               if (isset($e)) {
                                echo ' <input type="file" name="fileToUpload" id="fileToUpload"><br><div class="form-actions">';
                                    if (strpos($url, 'e=0')!== false)
                             { echo "you haven't chosen a file to upload.";}
                           elseif (strpos($url, 'e=1')!== false) {
                               echo "Sorry, file already exists.";
                         }
                         elseif (strpos($url, 'e=2')!== false) {
                              echo "Sorry, your file is too large.";
                         }
                         elseif (strpos($url, 'e=3')!== false) {
                              echo "Sorry, only word, Excel & PDF files are allowed.";
                         }
                         elseif (strpos($url, 'e=4')!== false) {
                              echo "Sorry, your file was not uploaded.";
                         }
                         elseif (strpos($url, 'e=5')!== false) {
                          echo "Sorry, there was an error uploading your file.";
                         }


                         echo '<br> <br>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>';
                               }
                               else {
                                 echo "<h2> Vous n'appartenez à aucun site donc vous ne pouvez pas ajouter un document</h2>";
                               }
                            ?>
                            
                    
                    
                        
                    </form>


                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
        