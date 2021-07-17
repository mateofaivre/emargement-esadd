<?php   
session_start();

if (!isset($_SESSION['idProfAdmin'])){
    $idUser = $_SESSION["id"];
}
else {
    $idUser = $_SESSION["idProfAdmin"]; 
}
$uid = $_GET["uid"];

if (isset($_GET['idCours'])){
    $idCours = $_GET['idCours'];
}
else {
    $idCours = $_SESSION["idCours"];
}


if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $_SESSION["isProf"] = 1) { //liste tous les eleves

    include 'connexionBDD.php';
    $stmt =$dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, photoUser
    FROM user INNER JOIN groupeuser ON groupeuser.idUser = user.idUser AND user.isProf = 0 INNER JOIN groupe ON groupe.idGroupe = groupeuser.idGroupe AND groupe.idGroupe = '$uid' LEFT JOIN coursuser ON coursuser.idUser = user.idUser AND coursuser.idCours = '$idCours' WHERE coursuser.idUser IS NULL");
    $donnees = $stmt-> execute();   
    
    $stmt2 = $dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, photoUser, heureArrivee, typeCours FROM user, groupe, cours, groupeuser, coursuser WHERE groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = coursuser.idUser AND coursuser.idCours = cours.idCours AND coursuser.idCours = '$idCours' AND groupe.idGroupe = '$uid' AND user.isProf = 0 ORDER BY nomUser");
    $donnees2 = $stmt2 -> execute();

    $stmtCours = $dbh -> prepare("SELECT nomMatiere, nomGroupe, nomPromo, nomUser, prenomUser, datetimeDebut, datetimeFin FROM matiere, cours, groupe, promo, user WHERE cours.idGroupe = groupe.idGroupe AND cours.idMatiere = matiere.idMatiere AND groupe.idPromo = promo.idPromo AND cours.idUser = user.idUser AND cours.idCours = '$idCours' AND cours.isEnded = 0 ");
    $donneesCours = $stmtCours-> execute();
    $donneesCours =  $stmtCours -> fetch();

    if ($stmtCours->rowCount() == 0) {
        header("Location: 404.php");
    }
  
    $donneesCours['datetimeDebut'];
    $dateDebutCours = strtotime($donneesCours['datetimeDebut']);
    $dateFinCours = strtotime($donneesCours['datetimeFin']);
   
    $heureDebut = date('Y-m-d H:i:s', $dateDebutCours);
    $dateCours = date('d/m/Y', $dateDebutCours);
    $anneeCours = date('Y', $dateDebutCours);
    $debutCours = date('H:i', $dateDebutCours);
    $_SESSION['heureDebut'] = $dateDebutCours;
    $finCours = date('H:i', $dateFinCours);


    $year = date('Y', $dateDebutCours);
    if(date('n', $dateDebutCours) < 8)    
         $anneeScolaire = ( $year - 1).'-'. $year;
    else
        $anneeScolaire = ( $year).'-'.( $year + 1);
   
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../css/liste.css">
    <title>Liste des élèves</title> 
</head>
<body>

    <form method="post" action="liste-action.php?uid=<?php echo $uid ?>" id="containerAll">
    <div class="containerEleves">   
            <h1>Feuille de présence</h1> <h3>Date <span><?php echo $dateCours ?></span></h3>
            <hr id="hrUn">
                <div class="infos">
                    <div class="reponsesInfos">Promo <span><?php echo $donneesCours['nomPromo']; ?></span></div>
                    <div class="reponsesInfos left">Groupe <span><?php echo $donneesCours['nomGroupe']; ?></span></div>
                    <div class="reponsesInfos left" id="infoIntervenant">Prof <span><?php echo $donneesCours['nomUser']." ".$donneesCours['prenomUser']; ?></span></div>
                    <div class="reponsesInfos droite">Année <span><?php echo $anneeScolaire; ?></span></div>
                    <div class="reponsesInfos">Matière <span><?php echo $donneesCours['nomMatiere']; ?></span></div>
                    <div class="reponsesInfos left">Créneau <span><?php echo $debutCours."-".$finCours; ?></span></div>
                    <div class="reponsesInfos left">Retards <span id="nbRetards"></span></div>
                    <div class="reponsesInfos droite">Total présents <span class="nbStudents"><?php getNbStudents($stmt, $donnees, $stmt2, $donnees2); ?> </span> </div>
                </div>
                <a href="" class="btAction" id="btRefreshPhone">Rafraîchir</a>
                <?php getStudents($stmt, $donnees, $stmt2, $donnees2, $heureDebut); ?>
                </div>
        
        <div class="buttons">
            <a href=<?php if (isset($_SESSION['prenomProfChoisi'])){ echo "fiche-admin.php";} else { echo "fiche.php?cours=new"; }; ?> class="btAction" id="btNewCours" target="_blank">Nouveau cours</a>
            <a href="" class="btAction" id="btRefresh">Rafraîchir</a>
            <input type="submit" class="btAction" id="btSigner" name="btSigner" value="Signer">        
        </div>
        <div id="modalWindow" class="modal">
            <div class="modal-content">

                <div class="containerHtab"><span class="hTab hTabSelected">Présence</span><span class="hTab">Absence</span><span class="hTab">Retard</span></div>
                <div class="tabModal tabSelected">              
                <p id='pPresent' class="pMotif">Confirmez-vous la ponctualité de <span class="spanNoms"></span> <span class="spanPrenoms"></span> ?</p>
                 </div>

                <div class="tabModal">
               
                <p id='pAbsent' class="pMotif">Confirmez-vous l'absence de <span class="spanNoms"></span> <span class="spanPrenoms"></span> ?</p>
                </div>

                <div class="tabModal">
              

                <p id='pRetard' class="pMotif"><span class="spanNoms"></span> <span class="spanPrenoms"></span> est en retard de <?php
                $currentDate = date_create(date('Y-m-d H:i:s'));
                    $heureDebutCours = strtotime("+2 minutes", strtotime($heureDebut));
                  $heureDebutCours = date('Y-m-d H:i:s', $heureDebutCours);
                  $heureDebutCours = date_create($heureDebutCours);
                $interval = date_diff($currentDate, $heureDebutCours);

                if ( $interval->format('%H' ) > 0){
                  ?><style> 
                     .containerHeureRetard {
                         display:inline;
                     }
                    </style><?php
                }
                else { ?>
                    <style>
                     .containerHeureRetard {
                         display:none;
                     }
                    </style>
                <?php }
                
                ?>
                <span class="containerHeureRetard"><input type="number" class="inputRetard" id="inputHeureRetard" name="inputHeureRetard" value="<?php echo  $interval->format('%H' ) ?>"/> h </span>
                 <span class="containerMinRetard"><input type="number" class="inputRetard" id="inputMinRetard" name="inputMinRetard" value="<?php echo  $interval->format('%I' ) ?>"/> min. </span> </p>

                </div>

                <div class="actionBtns">
                    <a href="#"  name="annuler" id="annulerModal" class="btnModal">Annuler</a>
                    <input type="submit" value="À l'heure" name="alheure" id="alheure" class="btnModal"/>
                    <input type="submit" value="Valider" name="valider" id="validerModal" class="btnModal"/>
                </div>

                <a href="#" class="modal-close">&times;</a>
            </div>
        </div>
       
    </form>
    <script src="../../js/liste.js"></script>
</body>
</html>
    
<?php 

function getNbStudents($paramStmt, $paramDonnees, $paramStmt2, $paramDonnees2){
    echo $paramStmt2->rowCount(). "/" .($paramStmt->rowCount()+$paramStmt2->rowCount()); ;
}

function getStudents($paramStmt, $paramDonnees, $paramStmt2, $paramDonnees2, $paramHeureDebut){ //liste eleves

   
   
    $_SESSION['idAbsent'] = array();
    $rougeNb =0;
    $vertNb = 0;
   
    while ($paramDonnees =$paramStmt->fetch()) { ?>
    
        <div class="ligne">
        <div class="photo"> <img src="../../../images-users/<?php echo $paramDonnees["photoUser"]; ?>" alt=""> </div>
            <div class="nomRed nom"> <span class="nomEleve"><?php echo $paramDonnees["nomUser"]; ?></span> <span class="prenomEleve"> <?php echo $paramDonnees["prenomUser"]; ?></span> </div>
            <div class="icon">
           
            <a href="#modalWindow" class="linkToModal"><img src="../../img/Icons/Edit.svg"></a>
            </div>
        </div>
            <?php

        $_SESSION["idAbsent"][] = $paramDonnees["idUser"];
        $vertNb++;
    }

    $_SESSION['idPresent'] = array();

    while ($paramDonnees2 =$paramStmt2->fetch()) { 

       $heureDebutCours = strtotime($paramHeureDebut);
       $heureArrivee = strtotime($paramDonnees2['heureArrivee']); 
     
        ?>

        <div class="ligne">
        <div class="photo"> <img src="../../../images-users/<?php echo $paramDonnees2["photoUser"]; ?>" alt=""> </div>
       <?php if ($heureArrivee > $heureDebutCours) {

        $heureArrivee = new DateTime(date('Y-m-d H:i:s', $heureArrivee));
        $heureDebutCours = new DateTime(date('Y-m-d H:i:s', $heureDebutCours));
        $tempsRetard = date_diff($heureArrivee, $heureDebutCours);
       
            ?>

        <div class="nomOrange nom"> <span class="nomEleve"><?php echo $paramDonnees2["nomUser"]; ?></span> <span class="prenomEleve"> <?php echo $paramDonnees2["prenomUser"]; ?> </span> <span class="heuresRetard"><?php echo  $tempsRetard->format('%H' ); ?></span> <span class="minsRetard"><?php echo  $tempsRetard->format('%I'); ?></span>
            </div>

            <div class="icon">
            <?php if ($paramDonnees2["typeCours"] == 1){
                ?> <img src="../../img/Icons/pc-monitor.svg" alt=""> <?php
            } ?>
            <a href="#modalWindow" class="linkToModal linkRetard"><img src="../../img/Icons/Edit.svg"></a>
            </div>
        <?php    }
        else { ?>
            <div class="nomGreen nom"> <span class="nomEleve"><?php echo $paramDonnees2["nomUser"]; ?></span> <span class="prenomEleve"> <?php echo $paramDonnees2["prenomUser"]; ?>  </span> <?php
            if ($paramDonnees2["typeCours"] == 1){
                ?> <img src="../../img/Icons/pc-monitor.svg" alt=""> <?php
            } ?>
            </div>
            
            <div class="icon">
            <a href="#modalWindow" class="linkToModal"><img src="../../img/Icons/Edit.svg"></a>
            </div>

      <?php  }?>
           
        </div> <?php
        $_SESSION["idPresent"][] = $paramDonnees2["idUser"];
        $rougeNb++;
    }      
}   




