<?php 

session_start();

date_default_timezone_set('Europe/Paris');
$currentTime = date('H:i:s');

include 'connexionBDD.php';

$idUser = $_SESSION["id"];
if (isset($_GET['idProfAdmin'])) {
    $_SESSION["idProfAdmin"] = $_GET['idProfAdmin'];
    $idUser = $_SESSION['idProfAdmin'];
    $stmtPrenomProfChoisi = $dbh -> prepare("SELECT prenomUser FROM user WHERE idUser = '$idUser'");
    $donneesPrenomProfChoisi = $stmtPrenomProfChoisi-> execute();
    $donneesPrenomProfChoisi = $stmtPrenomProfChoisi->fetch();
    $_SESSION['prenomProfChoisi'] = $donneesPrenomProfChoisi['prenomUser'];
}

if (isset($_SESSION['idProfAdmin'])){
    $idUser = $_SESSION['idProfAdmin'];
}

$stmtCoursProf = $dbh -> prepare("SELECT idCours, nomUser, prenomUser, nomMatiere, datetimeDebut, datetimeFin, cours.idGroupe, nomGroupe FROM user, cours, matiere, groupe WHERE cours.idUser = user.idUser AND cours.idUser = '$idUser' AND datetimeDebut > CURRENT_DATE AND cours.idMatiere = matiere.idMatiere AND cours.idGroupe = groupe.idGroupe AND isEnded = 0");
$donneesCoursProf = $stmtCoursProf-> execute();

$uid = $_GET["uid"];

$idTest = $_GET["uid"];
$lettre='';

if (strpos($uid, 'd') !== false){
    $uid = 0;
}   
if (strpos($uid, 'm') !== false){
    $uid = 1;
}
if (strpos($uid, 'p') !== false){
    $uid = 2;
}
if (strpos($uid, 'g') !== false){
    $uid = 3;
}
if (strpos($uid, 'r') !== false){
    $uid = 4;
}

$nomFct = array (
    "Diplome",  
    "Matiere",
    "Promo",
    "Groupe"
);  

if (!isset($uid)){   
    $uid = 0;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/fiche.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/fiche.js" defer></script>
    <title>Fiche</title>
</head>
<body>   

<?php if ($stmtCoursProf -> rowCount() == 0 || isset($_GET['cours'])) { //prof n'a pas déjà crée un cours 

function checkIsConnected($paramFct, $paramUid, $paramIdUser, $paramLettre, $paramTest){

    if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

        if (isset($_GET['cours'])){                                                                                                                 
            $newCours = "cours=".$_GET['cours'];
        }
        else {
            $newCours = "";
        }
    
            include 'connexionBDD.php'; 

            if ($paramUid != 4){
            if ($paramUid == 0){
                $stmt = $dbh -> prepare("SELECT nomDiplome, diplome.idDiplome FROM diplome, promo, groupe, groupeuser, user WHERE diplome.idDiplome = promo.idDiplome AND promo.idPromo = groupe.idPromo AND groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = '$paramIdUser' GROUP BY nomDiplome ORDER BY nomDiplome");
            }
            if ($paramUid == 1){    
                $stmt = $dbh -> prepare("SELECT nomMatiere, idUser, matiere.idMatiere FROM matiere, usermatiere WHERE matiere.idMatiere = usermatiere.idMatiere AND idUser = '$paramIdUser' ORDER BY nomMatiere");
            }
            if ($paramUid == 2){   
                $idMatiere =  filter_var($_GET["uid"], FILTER_SANITIZE_NUMBER_INT);  
                $stmt = $dbh -> prepare("SELECT DISTINCT(promo.nomPromo), promo.idPromo FROM groupe, diplome, promo, user, groupeuser, matiere, matierepromo WHERE diplome.idDiplome = promo.idDiplome AND promo.idPromo = groupe.idPromo AND groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND matierepromo.idPromo = promo.idPromo AND matierepromo.idMatiere = matiere.idMatiere AND matiere.idMatiere = '$idMatiere' AND user.idUser = '$paramIdUser' ORDER BY nomPromo");
            }   
            if ($paramUid == 3){    
                $stmt = $dbh -> prepare("SELECT DISTINCT(groupe.nomGroupe), groupe.idGroupe FROM groupe, diplome, promo, user, groupeuser WHERE groupe.idGroupe = groupeuser.idGroupe AND groupe.idPromo = promo.idPromo AND promo.idDiplome = diplome.idDiplome AND groupeuser.idUser = user.idUser AND user.idUser ='$paramIdUser' AND promo.idPromo = '$paramTest' ORDER BY nomGroupe");
            }   
          
    
            $donnees = $stmt-> execute();
            $nbResultats = $stmt -> rowCount();
    
            while ($donnees = $stmt->fetch()) {
                if($paramUid == 0){
                    $paramLettre='m';
                }
                if($paramUid == 1){
                    $paramLettre='p';
                }
                if($paramUid == 2){
                    $paramLettre='g';
                }
                if($paramUid == 3){
                    $paramLettre='r';
                }
            ?>
          <a href='?<?php echo $newCours ;?>&uid=<?php
            echo $donnees["id$paramFct[$paramUid]"].$paramLettre."#".$_GET["uid"];
            ?>' class="btnEtape"
          >
          <?php
         
            echo $donnees["nom$paramFct[$paramUid]"];
          ?>
           <i class="fal fa-arrow-circle-right"></i>
          </a>
            <?php 
            
            $lien =  $donnees["id$paramFct[$paramUid]"].$paramLettre."#".$_GET["uid"];
    
            if ($nbResultats<2){
                header ("Location: fiche.php?$newCours&uid=$lien");
            }
           
        }
        $_SESSION["uid$paramFct[$paramUid]"] = filter_var($_GET["uid"], FILTER_SANITIZE_NUMBER_INT);
       
        $stmt ->closeCursor();
     
        }
        if ($paramUid == 4 || $paramUid == 5) {
            $_SESSION["isConnected"]= $row["codeUser"];
            header ("Location: recap.php?uid=$paramTest");
        }
    
        }
    
        else {
            echo "vs n'avez pas accès à cette page";
            header("refresh:5;url=login-client.php");
            die();
        }
     
    }  


  ?>

        <div class="products">  
            
            <div class="product" product-id="0"  product-color="#D18B49">

            <h1 class="title"><?php if ($uid == 0){
                echo 'Choissisez un diplôme';
            }
            else if ($uid == 1){
                echo 'Choissisez une matière';
            }
            else if ($uid == 2){
                echo "Choissez une promo";
            }
            else if ($uid == 3){
                $nomFctMin[$uid] = strtolower($nomFct[$uid]);
                echo "Choissez un  $nomFctMin[$uid]";
            }
            ?></h1>   

            <div class="containerBtn">
                    <?php checkIsConnected($nomFct,$uid, $idUser, $lettre, $idTest);?>
                </div>
            </div>

        </div>

        <div class="footer"><i class="fal fa-arrow-left"></i></div>

        <a class="lienAdmin" href="../../../espace-admin.php">Espace admin</a>
</body>
</html>

<?php 

}

else { ?>

    <style>
    /* :root {
        --colorText: #FFA900;
        --colordark : #333333;
    } */

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

        }

        main{
            padding: 2rem 0;
            width: 70%;
            margin-left:auto;
            margin-right: auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .existantTop {
            margin-top: 0;
        }

        .containerCours {
            display: flex;
            flex-direction: row;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .coursLink {
            color: var(--colorText);
            font-family: 'Futura PT Demi';
            font-weight: 600;
            display:flex;
            flex-direction: column;
            text-align: center;
            width: fit-content;
            margin: auto 1rem;
            font-size: 1.3rem;
        }

        .coursLink:hover, .newCours:hover,  .lienNewCours:hover {
            opacity: .5;
            cursor: pointer;
        }

        .infosCours {
            margin: 0 2rem;
        }

        .newCours {
            color: var(--colorText);
        }

        .lienNewCours {
            color: var(--colorText);
        }

    </style>

    <main>
    <?php if ($stmtCoursProf -> rowCount() == 1){ ?>
        <h1 class="hCoursExistant existantTop"><?php if (isset($_SESSION['prenomProfChoisi'])) { echo $_SESSION['prenomProfChoisi'].", vous"; }  else { echo "Vous";}?> avez déjà créé un cours aujourd'hui, vous pouvez soit y accéder :</h1>
    <?php }
    else { ?>
        <h1 class="hCoursExistant existantTop">Vous avez déjà créé plusieurs cours aujourd'hui, vous pouvez soit y accéder :</h1>
   <?php } ?>

    <div class="containerCours">

<?php while ($donneesCoursProf = $stmtCoursProf -> fetch()){
    $dateDebut = strtotime($donneesCoursProf['datetimeDebut']);
    $dateDebut = date('H:i', $dateDebut);


    $dateFin = strtotime($donneesCoursProf['datetimeFin']);
    $dateFin = date('H:i', $dateFin);
    $url ="$_SERVER[REQUEST_URI]";
   
    $uidAndAfterUid = substr($url, strpos($url, "=") + 1);

    ?><a href="liste.php?uid=<?php echo $donneesCoursProf['idGroupe']."&idCours=". $donneesCoursProf['idCours']; ?>" class="coursLink">
        <span class="infosCours matiere"> <?php echo $donneesCoursProf['nomMatiere']; ?></span>
        <span class="infosCours groupe"> <?php echo $donneesCoursProf['nomGroupe']; ?></span>
        <span class="infosCours creneau"><?php echo $dateDebut." - ".$dateFin; ?></span>
    </a>

<?php } ?>
    
    </div>

    <h1 class="hCoursExistant">soit en créer <a href="fiche.php?uid=<?php echo $_GET['uid']."&cours=new"; ?>" class="newCours">un nouveau.</a></h1>

    <?php if ($_SESSION['user_name'] == 'test@esadd.fr') { ?>
       <a href="fiche-admin.php" class="newCours"> <h3>Ou devenir un autre professeur, cher super admin. 🎩</h3></a> 
    <?php } ?>
    </main>

    
    </body>
    </html>
    <?php
}

?>




