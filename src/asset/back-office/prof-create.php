<?php
    include "../include/connexion-database.php";

    if(isset($_POST["user_nom"], $_POST["user_prenom"], $_POST["user_email"], $_POST["user_photo"], $_POST["user_code"])){
        $nom = $_POST["user_nom"];
        $prenom = $_POST["user_prenom"];
        $email = $_POST["user_email"];
        $photo = $_POST["user_photo"];
        $code = $_POST["user_code"];

        $stmt = $dbh->prepare("INSERT INTO user (nomUser, prenomUser, mailUser, photoUser, codeUser, isProf) VALUES (:nom, :prenom, :email, :photoUser, :code, '1')");
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':photoUser', $photo, PDO::PARAM_STR);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);

        $execOkay = $stmt->execute();
    }

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){

        $nom_edit = $_POST["user_nom"];
        $prenom_edit = $_POST["user_prenom"];
        $email_edit = $_POST["user_email"];
        $photo_edit = $_POST["user_photo"];
        $code_edit = $_POST["user_code"];

        $id = $_GET['id'];
        $stmt_s = $dbh->prepare("UPDATE user (nomUser, prenomUser, mailUser, photoUser, codeUser) VALUES (:nom, :prenom, :email, :photoUser, :code)");
        
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':photoUser', $photo, PDO::PARAM_STR);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);

        $donnees_s = $stmt_s->execute();
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un professeur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="profs.php">Profs</a></li>
        <li><a href="../eleves/eleves.php">Elèves</a></li>
        <li><a href="../matieres/matieres.php">Matières</a></li>
        <li><a href="../groupes/groupes.php">Groupes</a></li>
        <li><a href="../promos/promos.php">Promos</a></li>
        <li><a href="../diplomes/diplomes.php">Diplômes</a></li>
    </ul>

    <div class="form-popup" id="form-profs">
        <form action="prof-create.php" method="post" enctype="multipart/form-data">

            <label for="user_nom"><?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                $id = $_GET['id'];
                $stmt_d = $dbh->prepare("SELECT idUser, nomUser, prenomUser, mailUser, codeUser FROM user WHERE isProf = 1 AND idUser='$id'");
                $donnees_d = $stmt_d->execute();
                $donnees_d = $stmt_d->fetch();
                echo $donnees_d['nomUser'];
            }?>
            </label>
            <input type="text" id="user_nom" name="user_nom" placeholder="Nom">

            <label for="prenom"><?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                echo $donnees_d['prenomUser'];
            }?>
            </label>
            <input type="text" id="user_prenom" name="user_prenom" placeholder="Prenom">

            <label for="user_email"><?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                echo $donnees_d['mailUser'];
            }?>
            </label>
            <input type="email" id="user_email" name="user_email" placeholder="Email">

            <input type="text" id="user_photo" name="user_photo" placeholder="URL de la photo">

            <input type="file" id="user_signature" name="user_signature">

            <label for="user_code"><?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                echo $donnees_d['codeUser'];
            }?>
            </label>
            <input type="text" id="user_code" name="user_code" placeholder="Code">

            <input type="submit" id="submitBtn" name="submitBtn" value="<?php
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                echo "Mettre à jour";
            }
            else{
                echo "Ajouter";
            }
            ?>">
        </form>
    </div>
    
    <script src="../main.js"></script>
</body>
</html>