<?php 

session_start();

$idDiplome = $_POST['select_diplome'];
echo $nomPromo = $_POST['promo_nom'];
echo $dateCreation = $_POST['date_rentree'];

include "../../client-side/connexionBDD.php";


if (isset($_GET["action"]) && $_GET["action"]=="edit"){

    $idPromo = $_GET['id'];
    $idDiplomeBefore = $_SESSION['diplome_selected'];
    $stmtUpdatePromo = $dbh->prepare("UPDATE promo SET nomPromo='$nomPromo', idDiplome='$idDiplome', dateCreation= '$dateCreation' WHERE idPromo= '$idPromo' ");  
    $donneesUpdatePromo = $stmtUpdatePromo->execute();

}
else {
    $stmtInsertPromo = $dbh->prepare("INSERT INTO promo (idPromo, nomPromo, idDiplome, dateCreation) VALUES ('', '$nomPromo', '$idDiplome', '$dateCreation')");  
    $donneesInsertPromo = $stmtInsertPromo->execute();
}

$_SESSION['error_message'] = "";    
$_SESSION['done_message'] = "Les modifications ont bien été prises en compte.";

header("Location: promos-create.php?action=edit&id=$idPromo&promo=$nomPromo&idDiplome=$idDiplome");