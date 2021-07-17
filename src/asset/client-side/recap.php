<?php   

session_start();

$uid = $_GET["uid"];
function getCreneau(){

    date_default_timezone_set('Europe/Paris'); // CDT
    $current_date_day = date('d/m/Y');
    $current_date_dayBDD = date('Y/m/d');
    
    $current_date = date('d/m/Y H:i:s');
    $current_hour = date('H:i:s'); 
    $heureDebut = 0;
    $heureFin = 0;
    if ($current_hour > "08:45:00" && $current_hour < "12:45:00") {
        $heureDebut = "09:00";
        $heureFin = "12:30";
    }
    if ($current_hour > "12:45:01" && $current_hour < "17:05:00"){
        $heureDebut = "13:30";
        $heureFin = "17:00";
    }
    if ($current_hour > "17:10:00" && $current_hour < "23:59:59"){
        $heureDebut = "17:15";
        $heureFin = "18:15";
    }
    if ($current_hour < "08:44:59" && $current_hour > "00:00:00"){
        $heureDebut = "08:00";
        $heureFin = "09:00";
    }
    $_SESSION["dateBDD"] = $current_date_dayBDD;
?>
    <input type="time" class="inputTime" name="inputTimeDebut" name="inputTimeDebut" min="" max="" value="<?php echo $heureDebut ?>" required>
    -
    <input type="time" class="inputTime" id="inputTimeFin" name="inputTimeFin" min="" max="" value="<?php echo $heureFin ?>" required>
    
 <?php
}

function getYear(){

    $time = time() + (7 * 24 * 60 * 60);
    $year = date('Y', $time);
    if(date('n', $time) < 8)
     $ayear = ($year - 1).' - '.$year;
    else
    $ayear = ($year).' - '.($year + 1);
    echo $ayear;
    $_SESSION["anneeScolaire"] = $ayear;

}

function getDatee(){
    date_default_timezone_set('Europe/Paris'); // CDT
    $current_date = date('d/m/Y');
    echo $current_date;
    
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif</title>    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../css/recap.css">
</head>
<body>
    <form method="post" action="recap-action.php?uid=<?php echo $uid?>" id="containerAll">
    <!-- <form method="post" action="recap-action.php?uid=<?php echo pushReponses('diplome');?>" id="containerAll"> -->
        <div id="containerDiplome" class="ligne">
            <div class="titre" id="hrecap">Récapitulatif</div>
            <div class="reponse" id="reponseDiplome">
            <?php $element = 'diplome'; pushReponses($element); ?>
            </div>
        </div>
        <div id="containerDate" class="ligne">
            <div class="titre">Date</div>
            <div class="reponse">
                <?php getDatee(); ?>
            </div>
        </div>
        <div id="containerCreneau" class="ligne">
            <div class="titre">Créneau horaire</div>
            <div class="reponse">
                 <?php getCreneau(); ?></div>
        </div>  
        <div id="containerAnnee" class="ligne"> 
            <div class="titre">Année</div>
            <div class="reponse"><?php getYear(); ?></div>
        </div>
        <div id="containerPromo" class="ligne">
            <div class="titre">Promo</div>
            <div class="reponse"> <?php $element = 'promo'; pushReponses($element); ?></div>
        </div>
        <div id="containerGroupe" class="ligne">
            <div class="titre">Groupe</div>
            <div class="reponse"> <?php $element = 'groupe'; pushReponses($element); ?></div>
        </div>
        <div id="containerMatiere" class="ligne">
            <div class="titre">Matière</div>
            <div class="reponse">
                <?php $element = 'matiere'; pushReponses($element); ?>
            </div>  
        </div>
        <div id="containerIntervenant" class="ligne">
            <div class="titre">Intervenant</div>
            <div class="reponse">
                <?php $element = 'nomUser'; pushReponses($element); ?>
            </div>
        </div>
       
        <a href='' class="lienBt"><button class="btCreer" type='submit' name="submit" >Valider</button></a>

        <div class="footer"><i class="fal fa-arrow-left"></i></div>

    </form> 
    <script src="../../js/recap.js"></script>
</body>
</html>

<?php   


function pushReponses($paramElement){

    if (isset($_SESSION['id']) && isset($_SESSION['user_name'])){
    
        include 'connexionBDD.php'; 
    
        $uid = $_GET["uid"];
        
        if (!isset($_SESSION['idProfAdmin'])){
            $idUser = $_SESSION["id"];
        }
        else {
            $idUser = $_SESSION["idProfAdmin"]; 
        }  
        $idMatiere = $_SESSION["uidPromo"];
    
        $stmt = $dbh -> prepare("SELECT  DISTINCT nomDiplome, nomMatiere, matiere.idMatiere, promo.nomPromo, nomGroupe, nomUser, prenomUser  FROM diplome, matiere, promo, groupe, user, groupeuser, usermatiere WHERE promo.idDiplome = diplome.idDiplome AND groupe.idPromo = promo.idPromo AND groupeuser.idUser = user.idUser AND matiere.idMatiere = usermatiere.idMatiere AND usermatiere.idUser = user.idUser AND matiere.idMatiere ='$idMatiere' AND user.idUser = '$idUser' AND groupe.idGroupe = '$uid' ");
    
        $donnees = $stmt-> execute();    
       
        while ($donnees =$stmt->fetch()) {  
           
            $arrayReponses = array (
                "diplome" =>  $donnees["nomDiplome"],
                "matiere" =>  $donnees["nomMatiere"],
                "promo" =>  $donnees["nomPromo"],
                "groupe" =>  $donnees["nomGroupe"],
                "nomUser" =>  $donnees["prenomUser"]." ".$donnees["nomUser"]
            );
            echo $arrayReponses["$paramElement"];
            $_SESSION['idMatiere'] =$idMatiere;
    }

    
    }
    
}


?>