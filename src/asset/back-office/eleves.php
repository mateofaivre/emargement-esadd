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

            $stmt = $dbh->prepare("SELECT nomUser, prenomUser FROM user WHERE isProf = 0");
            $donnees = $stmt->execute();
    ?>

    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="../profs/profs.php">Profs</a></li>
        <li><a href="eleves.php">Elèves</a></li>
        <li><a href="../matieres/matieres.php">Matières</a></li>
        <li><a href="../groupe/groupe.php">Groupes</a></li>
        <li><a href="../promos/promos.php">Promos</a></li>
        <li><a href="../diplomes/diplomes.php">Diplômes</a></li>
    </ul>

    <table class="tableAll" id="table-eleves">
        <tr>
            <th>Elèves</th>
            <th><a href="eleve-create.php">Ajouter +</a></th>
        </tr>

        <?php
            while ($donnees = $stmt->fetch()){
        ?>

        <tr>
            <td style="width: 40%"><?php echo $donnees['nomUser']." ".$donnees['prenomUser']?></td>
            <td><a href="prof-edit.php"><img src="../assets/icons/Edit.svg" alt=""></a>
                <a href=""><img src="../assets/icons/croixRouge.svg" alt=""></a>
            </td>
        </tr>

        <?php
        }

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
    </table>

</body>
</html>