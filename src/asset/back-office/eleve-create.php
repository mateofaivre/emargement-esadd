<?php

        if(isset($_POST["user_nom"], $_POST["user_prenom"], $_POST["user_email"], $_POST["user_code"])){
            $nom = $_POST["user_nom"];
            $prenom = $_POST["user_prenom"];
            $email = $_POST["user_email"];
            $code = $_POST["user_code"];

        try {
            include "../include/connexion-database.php";

            $stmt = $dbh->prepare("INSERT INTO user (nomUser, prenomUser, mailUser, codeUser) VALUES (:nom, :prenom, :email, :code)");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);

            $execOkay = $stmt->execute();

            if ($execOkay == TRUE) {
                header("Location: eleves.php?msg=eleves_insert_ok"); exit;
                echo "L'élève a bien été créé";
            } else {
                echo "L'élève n'a pas été créé";
            } 

        } catch (Error $e) {
            echo $e->getMessage();
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une matière</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="../profs/profs.php">Profs</a></li>
        <li><a href="eleves/eleves.php">Elèves</a></li>
        <li><a href="../matieres/matieres.php">Matières</a></li>
        <li><a href="../groupes/groupes.php">Groupes</a></li>
        <li><a href="../promos/promos.php">Promos</a></li>
        <li><a href="../diplomes/diplomes.php">Diplômes</a></li>
    </ul>

    <div class="form-popup" id="form-eleves">
        <form action="eleves.php" method="post" enctype="multipart/form-data">
            <input type="hidden">
            <input type="text" id="user_nom" name="user_nom" placeholder="Nom">
            <input type="text" id="user_prenom" name="user_prenom" placeholder="Prenom">
            <input type="email" id="user_email" name="user_email" placeholder="Email">
            <input type="text" id="user_photo" name="user_photo" placeholder="URL de la photo">
            <input type="file" id="user_signature" name="user_signature">
            <input type="text" id="user_code" name="user_code" placeholder="Code">
            <input type="submit" id="submitBtn" name="submitBtn" value="Ajouter">
        </form>
    </div>
    
    
</body>
</html>