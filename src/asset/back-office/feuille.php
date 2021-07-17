<?php   
session_start();

$idCours = $_GET["idCours"];
$idGroupe = $_GET["idGroupe"];

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $_SESSION["isAdmin"] = 1 && $_SESSION["isActualUser"] == 1) { //liste tous les eleves

    include '../client-side/connexionBDD.php';
    $stmtAbsents =$dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, signatureUser
    FROM user
    INNER JOIN groupeuser ON groupeuser.idUser = user.idUser AND user.isProf = 0
    INNER JOIN groupe ON groupe.idGroupe = groupeuser.idGroupe AND groupe.idGroupe = '$idGroupe'
    LEFT JOIN coursuser ON coursuser.idUser = user.idUser AND coursuser.idCours = '$idCours'
    WHERE coursuser.idUser IS NULL");
    $donneesAbsents = $stmtAbsents-> execute();   
    
    $stmtPresents = $dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, signatureUser, datetimeDebut FROM user, groupe, cours, groupeuser, coursuser WHERE groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = coursuser.idUser AND coursuser.idCours = cours.idCours AND coursuser.idCours = '$idCours' AND groupe.idGroupe = '$idGroupe' AND user.isProf = 0 ORDER BY nomUser");
    $donneesPresents = $stmtPresents -> execute(); 
   

    $stmtTotal = $dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, null as signatureUser FROM user INNER JOIN groupeuser ON groupeuser.idUser = user.idUser AND user.isProf = 0 INNER JOIN groupe ON groupe.idGroupe = groupeuser.idGroupe AND groupe.idGroupe = '$idGroupe' LEFT JOIN coursuser ON coursuser.idUser = user.idUser AND coursuser.idCours = '$idCours' WHERE coursuser.idUser IS NULL UNION SELECT DISTINCT prenomUser, nomUser, user.idUser, signatureUser FROM user, groupe, cours, groupeuser, coursuser WHERE groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = coursuser.idUser AND coursuser.idCours = cours.idCours AND coursuser.idCours = '$idCours' AND groupe.idGroupe = '$idGroupe' AND user.isProf = 0 ORDER BY nomUser
    ");
      $donneesTotal = $stmtTotal -> execute();

    $stmtRetards = $dbh -> prepare("SELECT prenomUser, nomUser, cours.idCours, heureArrivee, datetimeDebut FROM user, cours, coursuser WHERE cours.idCours = coursuser.idCours AND user.idUser = coursuser.idUser AND heureArrivee > datetimeDebut AND cours.idCours = '$idCours' ORDER BY nomUser");
    $donneesRetards = $stmtRetards -> execute();


    $stmtCours = $dbh -> prepare("SELECT cours.idCours, nomUser, prenomUser, nomMatiere, nomPromo, nomGroupe, dateTimeDebut, dateTimeFin FROM user, cours, groupe, matiere, promo, matierepromo WHERE cours.idMatiere = matiere.idMatiere AND matiere.idMatiere = matierepromo.idMatiere AND matierepromo.idPromo = promo.idPromo AND cours.idGroupe = groupe.idGroupe AND groupe.idPromo = promo.idPromo AND cours.idUser = user.idUser AND cours.idCours ='$idCours' ");
    $donneesCours = $stmtCours -> execute();
    $donneesCours = $stmtCours -> fetch();

    $nbRetards = $stmtRetards->rowCount();
  
    $dateDebutCours = strtotime($donneesCours['dateTimeDebut']);
    $dateFinCours = strtotime($donneesCours['dateTimeFin']);
   
    $heureDebut = date('Y-m-d H:i:s', $dateDebutCours);
    $dateCours = date('d/m/Y', $dateDebutCours);
    $anneeCours = date('Y', $dateDebutCours);
    $debutCours = date('H:i', $dateDebutCours);
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../css/feuille.css">
    <title>Liste des élèves</title> 
</head>
<body>

<nav class="navbar">
    <ul class="navbar-nav">
      <li class="logo">
        <a href="#" class="nav-link">
        <?php if (isset($_SESSION['photoUser'])){
            ?>  <img class="" src="../../../images-users/<?php echo $_SESSION['photoUser'] ?>"  alt=""> <?php
          }
          else { ?>
            <span class="link-text logo-text" > <?php echo $_SESSION['name'];?></span>
          <?php  } ?>
        </a>
      </li>

      <li class="nav-item">
        <a href="home.php" class="nav-link">
        <img src="../../img/Icons/HomeOrange.svg" alt="">
        <span class="link-text">Accueil</span>
        </a>
        
      </li>

      <li class="nav-item">
        <a href="archives.php" class="nav-link">
        <img src="../../img/Icons/FolderOrange.svg" alt="">
        <span class="link-text">Archives</span>
        </a>
      </li>

      <hr class="separator">

      <li class="nav-item">
        <a href="profs/profs.php" class="nav-link">
        <img src="../..//img/Icons/MaletteOrange.svg" alt="">
        <span class="link-text">Professeurs</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="eleves/eleves.php" class="nav-link">
        <img src="../..//img/Icons/UserOrange.svg" alt="">
        <span class="link-text">Élèves</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="matieres/matieres.php" class="nav-link">
        <img src="../..//img/Icons/ParamsOrange.svg" alt="">
        <span class="link-text">Matières</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="groupes/groupes.php" class="nav-link">
        <img src="../..//img/Icons/2UsersOrange.svg" alt="">
        <span class="link-text">Groupes</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="promos/promos.php" class="nav-link">
        <img src="../..//img/Icons/3UsersOranges.svg" alt="">
        <span class="link-text">Promos</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="diplomes/diplomes.php" class="nav-link">
        <img src="../../img/Icons/DiplomeOrange.svg" alt="">
        <span class="link-text">Diplômes</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="droits/droits.php" class="nav-link">
        <img src="../../img/Icons/profile.svg" alt="">
        <span class="link-text">Droits</span>
        </a>
      </li>

      <hr class="separator">

      <li class="nav-item">
        <a href="../../../../../workshop-test" class="nav-link">
        <img src="../../img/Icons/books.svg" alt="">
        <span class="link-text">Feuilles</span>
        </a>
      </li> 

      
    </ul>
  </nav>

  <main>

    <form method="post" action="liste-action.php?uid=<?php echo $idGroupe ?>" id="containerAll">
        <div class="containerEleves">   
            <h1>Feuille de présence</h1> <h3>Date <span><?php echo $dateCours ?></span></h3>
            <hr id="hrUn">
                <div class="infos">
                    <div class="reponsesInfos">Promo <span><?php echo $donneesCours['nomPromo']; ?></span></div>
                    <div class="reponsesInfos left">Groupe <span><?php echo $donneesCours['nomGroupe']; ?></span></div>
                    <div class="reponsesInfos left" id="infoIntervenant">Intervenant <span><?php echo $donneesCours['nomUser']." ".$donneesCours['prenomUser']; ?></span></div>
                    <div class="reponsesInfos droite">Année <span><?php echo $anneeScolaire; ?></span></div>
                    <div class="reponsesInfos">Matière <span><?php echo $donneesCours['nomMatiere']; ?></span></div>
                    <div class="reponsesInfos left">Créneau <span><?php echo $debutCours."-".$finCours; ?></span></div>
                    <div class="reponsesInfos left">Retards <span><?php echo $nbRetards; ?></span></div>
                    <div class="reponsesInfos droite">Total présents <span class="nbStudents"><?php getNbStudents($stmtAbsents, $donneesAbsents, $stmtPresents, $donneesPresents); ?> </span> </div>
                </div>

                <div class="allCases">
                <?php getStudents($stmtAbsents, $donneesAbsents, $stmtPresents, $donneesPresents, $stmtTotal, $donneesTotal, $dbh, $idCours, $heureDebut); ?>
                </div>
        </div>
    </form>

    </main>
</body>
</html>
    
<?php 

function getNbStudents($paramStmtAbsents, $paramDonneesAbsents, $paramStmtPresents, $paramDonneesPresents){
    echo $paramStmtPresents->rowCount(). "/" .($paramStmtAbsents->rowCount()+$paramStmtPresents->rowCount()); ;
}

function getStudents($paramStmtAbsents, $paramDonneesAbsents, $paramStmtPresents, $paramDonneesPresents, $paramStmtTotal, $paramDonneesTotal, $paramDbh, $paramIdCours, $paramHeureDebut){ //liste eleves

    $_SESSION['idAbsent'] = array();
    $_SESSION['idPresent'] = array();
    $rougeNb =0;
    $vertNb = 0;
    $nbClass=0;
   
    while ($paramDonneesTotal =$paramStmtTotal->fetch()) {

        $img = $paramDonneesTotal["signatureUser"];
        
     

       ?>
        <div class="ligne <?php if ($nbClass < 3){ echo "plein ";}; if($nbClass == 5 || $nbClass == 2 ){ echo " borderlessRight";} if($nbClass == 3 || $nbClass == 0){ echo " borderlessLeft";}?>">
        <div class="nomUser"> <?php echo $paramDonneesTotal["prenomUser"]." ".$paramDonneesTotal["nomUser"]; ?></div>
            
            <?php if ($img != null){echo "<img class='imgSignatureEleve' src='$img'/>";
            $idUserRetard = $paramDonneesTotal["idUser"];
            $stmtColorRetard = $paramDbh -> prepare("SELECT heureArrivee FROM coursuser WHERE idUser= '$idUserRetard' AND idCours = '$paramIdCours' ");
            $donneesColorRetard = $stmtColorRetard->execute();
            $donneesColorRetard = $stmtColorRetard->fetch();

            $heureRetard = strtotime( $donneesColorRetard['heureArrivee']);
            $heureRetard = new Datetime(date('Y-m-d H:i:s', $heureRetard));
      
            $heureDebut = strtotime( $paramHeureDebut);
            $heureDebut = new Datetime(date('Y-m-d H:i:s', $heureDebut));
      
            $interval = $heureRetard->diff($heureDebut);
           
           
            ?><div class='tempsRetard' > <?php  if ($interval->format('%i min') > 0) { if ($interval->format('%i min') <= 59 && $interval->format('%h') == 0){
              echo $interval->format('%i min');
            }
            else {
              echo $interval->format('%h h %i min');
            } }?></div> <?php } ?>

        </div> 
          
        <?php $_SESSION["idPresent"][] = $paramDonneesTotal["idUser"];
        $rougeNb++;
        $nbClass++;

        if ($nbClass == 6) {
            $nbClass = 0;
       }

    }      
}   




