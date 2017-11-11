<?php 
   session_start();
    require 'database.php';
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $id = $_SESSION['id'];
    $site = $_POST['site'];
    $etat="pending";
    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s");  
    $name =basename($_FILES["fileToUpload"]["name"]);
    $name = preg_replace('/\s+/', '_', $name);
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $target_file = preg_replace('/\s+/', '_',$target_file);
    $uploadOk = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if file already exists
    if ($target_file=="uploads/") {
        $uploadOk = 0;
        header("Location: Ajouterdoc?e=0.php");
        exit();
    }
    if (file_exists($target_file)) {
        $uploadOk = 0;
        header("Location: Ajouterdoc?e=1.php");
        exit();
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000000) {
        $uploadOk = 0;
        header("Location: Ajouterdoc?e=2.php");
        exit();
    }
    // Allow certain file formats
    if($fileType != "pdf" && $fileType != "docx" && $fileType != "xlsx")
   {
        $uploadOk = 0;
        header("Location: Ajouterdoc?e=3.php");
        exit();
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: Ajouterdoc?e=4.php");

    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              // inserti les données
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $pdo->prepare("SELECT ename FROM employees WHERE eid=:uid");
            $stmt->execute(array(':uid'=>$id));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $emp= $row["ename"];
            $act = "ajouté";
            $sql = "INSERT INTO log (logemp,logaction,logdoc,logsite,logdate) values(?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($emp,$act,$name,$site,$today));
            $sql = "INSERT INTO documents (demployee,dname,dsite,ddate,detat) values(?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($emp,$name,$site,$today,$etat));
            

            Database::disconnect();
            $xmlDoc=new DOMDocument();
            $xmlDoc->load("docs.xml");
            $root = $xmlDoc->getElementsByTagName("documents")->item(0);
            $doc= $xmlDoc->createElement("doc");
            $doc1= $xmlDoc->createElement("name");
            $doc2= $xmlDoc->createElement("site");
            $docname = $xmlDoc->createTextNode($name);
            $docsite = $xmlDoc->createTextNode($site);
            $doc1->appendChild( $docname );
            $doc2->appendChild( $docsite );
            $doc->appendChild( $doc1 );
            $doc->appendChild( $doc2 );
            $root->appendChild( $doc );

            $xmlDoc->save("docs.xml");
            header("location:success.php");
        } else {
               header("Location: Ajouterdoc?e=5.php");
           
        }
    }

    ?>