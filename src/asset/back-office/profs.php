<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professeurs</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <?php
        include "../include/connexion-database.php";

        if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
            $id = $_GET['id'];
            $stmt_s = $dbh->prepare("DELETE FROM user WHERE idUser='$id'");
            $donnees_s = $stmt_s->execute();
        }
        $stmt = $dbh->prepare("SELECT idUser, nomUser, prenomUser FROM user WHERE isProf = 1");
        $donnees = $stmt->execute();
    ?>

    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="profs.php">Profs</a></li>
        <li><a href="../eleves/eleves.php">Elèves</a></li>
        <li><a href="../matieres/matieres.php">Matières</a></li>
        <li><a href="../groupe/groupe.php">Groupes</a></li>
        <li><a href="../promos/promos.php">Promos</a></li>
        <li><a href="../diplomes/diplomes.php">Diplômes</a></li>
    </ul>

    <table class="tableAll" id="table-profs">
        <tr>
            <th>Professeurs</th>
            <th><a href="prof-create.php">Ajouter +</a></th>
        </tr>

        <?php
            while ($donnees = $stmt->fetch()){
        ?>

        <tr>
            <td style="width: 40%"><?php echo $donnees['nomUser']." ".$donnees['prenomUser']?></td>
            <td><a href="prof-create.php?action=edit&amp;id=<?php echo $donnees['idUser']?>"><img src="../assets/icons/Edit.svg" alt=""></a>
                <a href="profs.php?action=delete&amp;id=<?php echo $donnees['idUser']?>"><img src="../assets/icons/croixRouge.svg" alt=""></a>
            </td>
        </tr>

        <?php
        }

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
    </table>

</body>
</html>