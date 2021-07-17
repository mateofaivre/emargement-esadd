<?php 

session_start();
include 'connexionBDD.php'; 

if ($_SESSION['user_name'] == 'test@esadd.fr') { 

    $stmtSuperAdmin = $dbh -> prepare("SELECT nomUser, prenomUser, idUser FROM user WHERE isProf = 1 AND isActualUser = 1");
    $donneesSuperAdmin = $stmtSuperAdmin-> execute();
    ?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/fiche-admin.css">
    <title>Super Admin</title>
</head>
<body>
    
    <section class="admin-wrapper">
        <h1 class="title">Deviens le professeur de ton choix</h1>
        <select name="select_prof" class="select-prof">
            <option disabled selected>Sélectionner un prof</option>
        <?php while ($donneesSuperAdmin = $stmtSuperAdmin->fetch()) { ?>
    
            <option value="<?php echo $donneesSuperAdmin['idUser']; ?>">
            <?php echo $donneesSuperAdmin['nomUser']." ".$donneesSuperAdmin['prenomUser']; ?>
            </option>
        
        <?php } ?>
        </select>
        <a class="btn-valider -disabled" href="">Valider</a>
    </section>

    <script src="../../js/fiche-admin.js"></script>
</body>
</html>

<?php }

else {
    header('Location: 404.php');
}