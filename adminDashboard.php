<?php
include 'Database.php';
session_start();
if (isset($_SESSION['id'])) {
 $id= $_SESSION['id'];
$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT ename FROM employees WHERE eid = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
       $row=$q->fetch(PDO::FETCH_ASSOC);
            $nom= $row["ename"];
        Database::disconnect();
}


?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2">                  
          <ul id="myTab" class="nav nav-tabs nav-justified">
              <div align="center"><br><br><br><br><strong>Bienvenu <?php echo $nom; ?></strong><br><br><br><br></div>
              <li class="active"><a href="#documents" data-toggle="tab"><strong>Mes documents</strong></a></li><br>
              <li class=""><a href="#gérerdocuments" data-toggle="tab"><strong>gérer les documents</strong></a></li><br>
              <li class=""><a href="#sites" data-toggle="tab"><strong>Mes sites</strong></a></li><br>
              <li class=""><a href="#gérersites" data-toggle="tab"><strong>gérer les sites</strong></a></li><br>
              <li class=""><a href="#gérerutilisateurs" data-toggle="tab"><strong>gérer les utilisateurs</strong></a></li><br>
              <li class=""><a href="#log" data-toggle="tab"><strong>Consulter les actions effectués</strong></a></li><br>
              <li class=""><a href="#reglages" data-toggle="tab"><strong>règlages</strong></a></li><br>
              <li class=""><a href="logout.php"><strong>se déconnecter</strong></a></li><br>
          </ul>

        </div>
        <div class="col-sm-offset-1 col-md-offset-1 col-sm-8 col-md-9">
          <div id="myTabContent" class="tab-content">


            <div class="tab-pane fade active in" id="documents">
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <h3>Vos documents</h3><br>
                  </div>
                </div>
                
            
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                  <div class="row">
                    <div class="col-sm-3">
                       <?php echo '<a class="btn btn-success"  href="ajouterdoc.php"> Ajouter un document</a>';?>
                    </div>
                    <div class="col-sm-3 col-sm-offset-6">
                      <form>
                    <input type="text" size="30" placeholder="rechercher un document..." onkeyup="showResult(this.value)">
                    <div id="livesearch"></div>
                    </form>
                    </div>
                  </div>
                   
                    

                       <div class="row">
                              <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <!-- na3rach 3lech ki na3mil th may7ibouch ijiw fil wist meme bil css, donc improvisit -->
                                    <td align="center"><strong>Date</strong></td>
                                    <td align="center"><strong>Nom du document</strong></td>
                                    <td align="center"><strong>site</strong></td>
                                    <td align="center"><strong>Etat</strong></td>
                                    <td align="center"><strong>Actions</strong></td>
                                  </tr>
                                </thead>
                                <br>
                                <tbody>
                                <?php
                             
                                 $pdo = Database::connect();
                                 $sql = "SELECT * FROM documents  WHERE demployee = '$nom' ORDER BY ddate DESC ";
                                 foreach ($pdo->query($sql) as $row) {
                                          echo '<tr>';
                                          echo '<td align="center">'. $row['ddate'] . '</td>';
                                          echo '<td align="center">'. $row['dname'] . '</td>';
                                          echo '<td align="center">'. $row['dsite'] . '</td>';
                                          echo '<td align="center">'. $row['detat'] . '</td>';
                                          echo '<td width=300>';
                                          echo ' ';
                                          echo '<a class="btn btn-success" href="updatedoc.php?id='.$row['did'].'&n='.$nom.'">Modifier</a>';
                                          echo ' ';
                                          echo '<a class="btn btn-warning" href="read.php?name='. $row['dname'] .'">Télécharger</a>';
                                          echo ' ';
                                          echo '<a class="btn btn-danger" href="deletedoc.php?id='.$row['did'].'">Supprimer</a>';
                                          echo '</td>';
                                          echo '</tr>';
                                 }
                                 Database::disconnect();
                                ?>
                                </tbody>
                              </table>
                        </div> 
                  </div>
                </div>
            </div>

            <div class="tab-pane fade" id="gérerdocuments">

                <div class="row"><h3>Documents à approuver</h3></div><br>
                <div class="row">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                 <td align="center"><strong>Date</strong></td>
                                    <td align="center"><strong>Nom du document</strong></td>
                                    <td align="center"><strong>Employé</strong></td>
                                    <td align="center"><strong>site</strong></td>
                                    <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php

                               $pdo = Database::connect();
                               $sql = "SELECT * FROM documents WHERE detat='pending' ORDER BY dsite DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td align="center">'. $row['ddate'] . '</td>';
                                        echo '<td align="center">'. $row['dname'] . '</td>';
                                        echo '<td align="center">'. $row['demployee'] . '</td>';
                                        echo '<td align="center">'. $row['dsite'] . '</td>';
                                        echo '<td width=300>';
                                        echo '<a class="btn btn-info" href="read.php?name='. $row['dname'] .'">Consulter</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-success" href="activate.php?id='.$row['did'].'&action=approuver">Approuver</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-danger" href="refuser.php?id='.$row['did'].'&action=refuser">Refuser</a>';
                                        echo '</td>';
                                                echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
                        <div class="row"><h3>Documents approuvés</h3></div><br>
                          <div class="row">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <td align="center"><strong>Date</strong></td>
                                  <td align="center"><strong>Nom du document</strong></td>
                                  <td align="center"><strong>Employé</strong></td>
                                  <td align="center"><strong>site</strong></td>
                                  <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php

                               $pdo = Database::connect();
                               $sql = "SELECT * FROM documents WHERE detat='approved' ORDER BY dsite DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td align="center">'. $row['ddate'] . '</td>';
                                        echo '<td align="center">'. $row['dname'] . '</td>';
                                        echo '<td align="center">'. $row['demployee'] . '</td>';
                                        echo '<td align="center">'. $row['dsite'] . '</td>';

                                        echo '<td width=250>';
                                        echo '<a class="btn btn-info" href="read.php?name='. $row['dname'] .'">Consulter</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-danger" href="deletedoc.php">Supprimer</a>';
                                        echo '</td>';
                                                echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
                         <div class="row">
                              <h3> Documents en attente de modification</h3>
                              <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <!-- na3rach 3lech ki na3mil th may7ibouch ijiw fil wist meme bil css, donc improvisit -->
                                    <td align="center"><strong>Date</strong></td>
                                    <td align="center"><strong>Nom du document</strong></td>
                                    <td align="center"><strong>site</strong></td>
                                    <td align="center"><strong>Actions</strong></td>
                                  </tr>
                                </thead>
                                <br>
                                <tbody>
                                <?php
                             
                                 $pdo = Database::connect();
                                 $sql = "SELECT * FROM documents WHERE demployee = '$nom' AND detat='quarantaine' ORDER BY detat DESC ";
                                 foreach ($pdo->query($sql) as $row) {
                                          echo '<tr>';
                                          echo '<td align="center">'. $row['ddate'] . '</td>';
                                          echo '<td ">'. $row['dname'] . '</td>';
                                          echo '<td align="center">'. $row['dsite'] . '</td>';
                                          echo '<td width=400>';
                                          echo '<a class="btn btn-success" href="updatedoc.php?id='.$row['did'].'&n='.$nom.'">Modifier</a>';
                                          echo ' ';
                                          echo '<a class="btn btn-info" href="activate.php?id='.$row['did'].'">Activer</a>';
                                          echo ' ';
                                          echo '<a class="btn btn-warning" href="read.php?name='. $row['dname'] .'">Télécharger</a>';
                                          echo ' ';
                                          echo '<a class="btn btn-danger" href="deletedoc.php?id='.$row['did'].'&n='.$nom.'">Supprimer</a>';
                                          echo '</td>';
                                          echo '</tr>';
                                 }
                                 Database::disconnect();
                                ?>
                                </tbody>
                              </table>
                        </div> 
                        <div class="row"><h3>Documents refusés</h3></div><br>
                          <div class="row">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <td align="center"><strong>Date</strong></td>
                                  <td align="center"><strong>Nom du document</strong></td>
                                  <td align="center"><strong>Employé</strong></td>
                                  <td align="center"><strong>site</strong></td>
                                  <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php

                               $pdo = Database::connect();
                               $sql = "SELECT * FROM documents WHERE detat='refused' ORDER BY dsite DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td align="center">'. $row['ddate'] . '</td>';
                                        echo '<td align="center">'. $row['dname'] . '</td>';
                                        echo '<td align="center">'. $row['demployee'] . '</td>';
                                        echo '<td align="center">'. $row['dsite'] . '</td>';

                                        echo '<td width=250>';
                                        echo '<a class="btn btn-info" href="read.php?name='. $row['dname'] .'">Consulter</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-danger" href="deletedoc.php">Supprimer</a>';
                                        echo '</td>';
                                                echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
                      </div>




          <div class="tab-pane fade" id="sites">
                                <div class="row"><h3>Vos Sites</h3></div><br>
                                <div class="row">
                                    <div class="col-sm-3">
                                     <ul class="nav nav-tabs nav-justified">
                                     <?php
                                        
                                         $sql = "SELECT * FROM sites ORDER BY sname DESC";
                                         foreach ($pdo->query($sql) as $row) {
                                          echo '<li class=""><a href="#'.$row['sname'].'" data-toggle="tab"><strong>'.$row['sname'].'</strong></a></li><br>';
                                          $b[]=$row['sname'];
                                         }Database::disconnect();
                                      ?>
                                    </ul>
                                  </div>
                                  <div class="col-md-9"> 
                                      <div id="myTabContent" class="tab-content">
                                     





                                        <?php 
                                        $pdo = Database::connect();
                                        $sql = "SELECT * FROM documents";
                                        foreach ($pdo->query($sql) as $row) {
                                          $docs[] = array(
                                                    "id" => $row['did'],
                                                     "name" => $row['dname'],
                                                     "site" => $row['dsite'],
                                                     "date"=>$row['ddate']   
                                            );

                                            
                                        }
                                        
                
                                      
                                          for ($i=0; $i <count($b) ; $i++)
                                           { 
                                                 echo '<div class="tab-pane fade" id="'.$b[$i].'">';   
                                                 echo '<table class="table table-striped table-bordered">
                                                 <thead>
                                                 <tr> 
                                                 <!-- na3rach 3lech ki na3mil th may7ibouch ijiw fil wist meme bil css, donc improvisit -->
                                                 <td align="center"><strong>Date</strong></td>
                                                    <td align="center"><strong>Nom du document</strong></td> 
                                                    <td align="center"><strong>Actions</strong></td>
                                                    </tr></thead><br>
                                                    <tbody>';
                                                     for ($d=0; $d <count($docs) ; $d++) 
                                                     {
                                                       if ($docs[$d]['site']==$b[$i] ) 
                                                       {  
                                                          echo '<tr>';
                                                          echo '<td align="center">'. $docs[$d]['date'] . '</td>';
                                                          echo '<td align="center">'. $docs[$d]['name'] . '</td>';
                                                          echo '<td width=200>';
                                                          echo '<a class="btn btn-info" href="read.php?name='. $docs[$d]['name'] .'">Afficher</a>';
                                                          echo ' ';
                                                          echo '<a class="btn btn-warning" href="read.php?id='.$docs[$d]['id'].'">Télécharger</a>';
                                                          echo '</td>';
                                                          echo '</tr>';
                                                       }
                                                     }
                                                      echo "</tbody></table></div>";
                                            }
                                         
                                       Database::disconnect();
                                          ?>  

                                   </div>
                                  </div>              
                      </div>  
              </div>





            <div class="tab-pane fade" id="gérersites">
                 <div class="row">
                 <h3 >Les sites</h3>
                 <a class="btn btn-success"  href="ajoutersite.php?">Ajouter un site</a>
                 </div><br>
                <div class="row">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <td align="center"><strong>Nom du site</strong></td>
                                 <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php
                           
                               $pdo = Database::connect();
                               $sql = "SELECT * FROM sites ORDER BY sid DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td>'. $row['sname'] . '</td>';
                                        echo '<td width=250>';
                                        echo '<a class="btn btn-success" href="updatesite.php?id='.$row['sid'].'">Modifier</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-danger" href="deletesite.php?id='.$row['sid'].'">Supprimer</a>';
                                        echo '</td>';
                                                echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
            </div>


             <div class="tab-pane fade" id="gérerutilisateurs">
                 <div class="row"><h3>Les employés</h3></div><br>
                <div class="row">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                 <td align="center"><strong>Nom de l'employé</strong></td>
                                 <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php
                           
                               $pdo = Database::connect();
                               $sql = "SELECT * FROM employees ORDER BY eid DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td>'. $row['ename'] . '</td>';
                                        echo '<td width=250>';
                                        echo '<a class="btn btn-success" href="acces.php?id='.$row['eid'].'">Accès</a>';
                                        echo ' ';
                                        echo '<a class="btn btn-danger" href="deleteuser.php?id='.$row['eid'].'">Supprimer</a>';
                                        echo '</td>';
                                                echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
            </div>

                <div class="tab-pane fade" id="log">
                   <div class="row"><h3 >Log des activités</h3></div><br>
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <td align="center"><strong>Date</strong></td>
                                 <td align="center"><strong>Actions</strong></td>
                                </tr>
                              </thead>

                              <tbody>
                              <?php
                           
                               $pdo = Database::connect();
                               $sql = "SELECT * FROM log ORDER BY logdate DESC ";
                               foreach ($pdo->query($sql) as $row) {
                                        echo '<tr>';
                                        echo '<td width=250>'. $row['logdate'] . '</td>';
                                        echo '<td>';
                                        echo $row['logemp'];
                                        echo " a "; 
                                        echo $row['logaction'];
                                        echo " le document ";
                                        echo '"';
                                        echo $row['logdoc'];
                                        echo '"';
                                        echo '</td>';
                                        echo '</tr>';
                               }
                               Database::disconnect();
                              ?>
                              </tbody>
                            </table>
                        </div> 
                        </div>
            </div> 





            <div class="tab-pane fade" id="reglages">
                <div class="row">
                 <div class="panel panel-login">
                    <div class="col-lg-6 col-lg-offset-3">
                            <br><br><br>
                                  <form action="change.php" method="POST">
                                    <h3>Changer vos informations</h3>
                                    <div class="form-group">
                                      <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="tapez votre nouveau nom" value="">
                                    </div>
                                    <div class="form-group">
                                      <input type="email" name="email" id="email" tabindex="2" class="form-control" placeholder="Tapez votre nouveau mail" value="">
                                    </div>
                                    <div class="form-group">
                                      <input type="password" name="password" id="password" tabindex="3" class="form-control" placeholder="Tapez votre mot de passe">
                                    </div>
                                    <div class="form-group">
                                      <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                          <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="valider">
                                        </div>
                                      </div>
                                    </div>
                                  </form><br><br><br><br>
                                  <form action="changepwd.php" method="POST">
                                    <h3>Changer votre mot de passe</h3>
                                    <div class="form-group">
                                      <input type="password" name="oldpassword" id="password" tabindex="5" class="form-control" placeholder="Tapez votre ancien mot de passe">
                                    </div>
                                    <div class="form-group">
                                      <input type="password" name="newpassword" id="password" tabindex="6" class="form-control" placeholder="tapez votre nouveau mot de passe">
                                    </div>
                                    <div class="form-group">
                                      <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                          <input type="submit" name="login-submit" id="login-submit" tabindex="7" class="form-control btn btn-login" value="Valider">
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                    </div>
                  </div>
                </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>  
      </div> 
    </div>
    <script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
