<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && $_SESSION["isAdmin"] == 1 && $_SESSION["isActualUser"]  == 1)  {

  include '../client-side/connexionBDD.php';

  // dates (- 1 mois ; -7 jours)
  date_default_timezone_set('Europe/Paris');
  $monthBeforeDate = date('Y/m/d');
  $weekBeforeDate = date('Y/m/d');
  $monthBeforeDate = strtotime("-1 month", strtotime($monthBeforeDate));
  $monthBeforeDate = date("Y/m/d", $monthBeforeDate);
  $weekBeforeDate = strtotime("-7 days", strtotime($weekBeforeDate));
  $weekBeforeDate = date("Y/m/d", $weekBeforeDate);

  //requete retards du mois
  $stmtMonth =$dbh -> prepare("SELECT DISTINCT coursuser.idUser, nomGroupe, cours.idGroupe, heureArrivee, coursuser.idCours, COUNT(cours.idGroupe) FROM groupe, user, cours, coursuser WHERE groupe.idGroupe = cours.idGroupe AND cours.idCours = coursuser.idCours AND isProf = 0 AND user.idUser = coursuser.idUser AND datetimeDebut > '$monthBeforeDate' AND heureArrivee > datetimeDebut GROUP BY cours.idGroupe");
  $donneesMonth = $stmtMonth-> execute();   
  if ($stmtMonth-> rowCount() == 0){
    ?> <style>
        #containerMonth {
            display:none;
        }
      </style> <?php
  }  

  //requete retards de la semaine
  $stmtWeek =$dbh -> prepare("SELECT DISTINCT coursuser.idUser, nomGroupe, cours.idGroupe, heureArrivee, coursuser.idCours, COUNT(cours.idGroupe) FROM groupe, user, cours, coursuser WHERE groupe.idGroupe = cours.idGroupe AND cours.idCours = coursuser.idCours AND isProf = 0 AND user.idUser = coursuser.idUser AND datetimeDebut > '$weekBeforeDate' AND heureArrivee > datetimeDebut GROUP BY cours.idGroupe");
  $donneesWeek = $stmtWeek-> execute(); 
  if ($stmtWeek-> rowCount() == 0){
    ?> <style>
        #containerWeek {
          display:none;
        }
      </style> <?php
  }  

  // inserer ds tableau pour graphique
  $dataCamembertMonth = array();
  $donneesMonthNb = 0;
  while ($donneesMonth = $stmtMonth->fetch()) { 
    $dataCamembertMonth[$donneesMonthNb]= array("label" => $donneesMonth["nomGroupe"], "y" => $donneesMonth["COUNT(cours.idGroupe)"]);
    $donneesMonthNb++;
  }

  $dataCamembertWeek = array();
  $donneesWeekNb = 0;
  while ($donneesWeek = $stmtWeek->fetch()) { 
    $dataCamembertWeek[$donneesWeekNb]= array("label" => $donneesWeek["nomGroupe"], "y" => $donneesWeek["COUNT(cours.idGroupe)"]);
    $donneesWeekNb++;
  }

    ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administration | Accueil</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
  <link rel="stylesheet" href="../../css/back-office.css">

  <!-- graphique -->
  <script>
    window.onload = function() {

    var chartMonth = new CanvasJS.Chart("chartMonth", {
      
      theme: "light1",
      animationEnabled: true,
      backgroundColor: "#f9f9f9",
      title: {
        text: "Retards du mois",
        fontFamily: "Futura PT",
        margin: 20,
        fontColor: '#A9A9A9',
        verticalAlign: "bottom",
        horizontalAlign: "center" 
      },
      
      data: [{
        type: "doughnut",
        fontFamily: "Futura PT",
        // indexLabel: "{symbol} - {y}",
        yValueFormatString: "####",
        showInLegend: true, 
        legendText: "{label} : {y}",
        dataPoints: <?php echo json_encode($dataCamembertMonth, JSON_NUMERIC_CHECK); ?>
      }]
    });
    

    var chartWeek = new CanvasJS.Chart("chartWeek", {
      theme: "light1",
      animationEnabled: true,
      backgroundColor: "#f9f9f9",
      title: {
        text: "Retards de la semaine",
        fontFamily: "Futura PT",
        margin: 20,
        fontColor: '#A9A9A9',
        verticalAlign: "bottom",
        horizontalAlign: "center" 
      },
      data: [{
        type: "doughnut",
        fontFamily: "Futura PT",
        // indexLabel: "{symbol} - {y}",
        yValueFormatString: "####",
        showInLegend: true,
        legendText: "{label} : {y}",
        dataPoints: <?php echo json_encode($dataCamembertWeek, JSON_NUMERIC_CHECK);?>
      }],
    });

    chartWeek.render();
    chartMonth.render();
   
    }

</script>
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

  <div class="containerGrid">

  <div class="containerL1">
  
  <section class="retards">
    <h2><i class="far fa-clock"></i> Retards du jour </h2>
    <?php getNames(); ?>
  </section>
  
  <section class="alertes">
    <h2><i class="far fa-bell"></i> Alertes</h2>
    <div class="containerAbsenteisme"><span>Élève</span><span>Promo</span><span>Matière(s)</span></div>
    <p>Aucun manque d'assiduité ou ponctualité à signaler.</p>
    <?php getAbsenteisme(); ?>
  </section>

  </div>

  <!--  recup presents, absents, retards, matiere, groupe du cours -->
  <div class="containerCours">
    <?php getCoursDatas(); ?>
  </div>
  <!-- graphiques -->
    <section id="containerMonth" class="containerChart">
      <div class="hideTrial"></div>
      <div id="chartMonth" class="chart" ></div>
  </section>
    
    <section id="containerWeek" class="containerChart">
      <div class="hideTrial"></div>
      <div id="chartWeek" class="chart"></div>
    </section>

    </div>

  </main>

  <script src="../../js/canvasjs.min.js"></script>
  <script src="../../js/back-office.js"></script>
</body>

</html>

<?php
}else{
    // header("Location: ../../../index.php");
                exit();
}

        
function getNames(){ // nom des eleves en retard

  include '../client-side/connexionBDD.php';

  $stmtNames =$dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, nomGroupe, nomMatiere, datetimeDebut, heureArrivee FROM user, coursuser, cours, groupe, groupeuser, matiere, usermatiere WHERE heureArrivee > datetimeDebut AND isProf = 0 AND user.idUser = coursuser.idUser AND coursuser.idCours = cours.idCours AND user.idUser = groupeuser.idUser AND groupeuser.idGroupe = groupe.idGroupe AND cours.idMatiere = matiere.idMatiere AND datetimeDebut > CURRENT_DATE() AND cours.idGroupe = groupe.idGroupe ORDER BY `user`.`nomUser` ASC");

  $donneesNames = $stmtNames-> execute();
  
  if ($stmtNames->rowCount() > 0){
    while ($donneesNames =$stmtNames->fetch()) {
 
      $heureRetard = strtotime( $donneesNames['heureArrivee']);
      $heureRetard = new Datetime(date('Y-m-d H:i:s', $heureRetard));

      $heureDebut = strtotime( $donneesNames['datetimeDebut']);
      $heureDebut = new Datetime(date('Y-m-d H:i:s', $heureDebut));

      $interval = $heureRetard->diff($heureDebut);
      $interval->format('%h h %i min');

      if ($interval->format('%i min') >= 2 && $interval->format('%i min') <= 15 && $interval->format('%h') == 0){
        $classRetard = 'retardJaune';
      }
      if ($interval->format('%i min') > 15 && $interval->format('%i min') <= 29 && $interval->format('%h') == 0){
        $classRetard = 'retardOrange';
      }

      if ($interval->format('%i min') > 29 && $interval->format('%i min') <= 59 && $interval->format('%h') == 0){
        $classRetard = 'retardRouge';
      }

      if ( $interval->format('%h') > 0){
        $classRetard = 'retardNoir';
      }
?>
      <div class="retardataires ">
        <div class="nomEleve"><?php echo $donneesNames["prenomUser"]." ".$donneesNames["nomUser"] ?></div>
        <div class="groupeEleve"><?php echo $donneesNames["nomGroupe"] ?></div>
        <div class="matiereEleve"><?php echo $donneesNames["nomMatiere"] ?></div>
        <div class="tempsRetard <?php echo $classRetard; ?>"></div>
      </div> 
      <?php
    }
  } 
  else {
    ?> <style>
    .retards{
      display:none;
    }
    </style>
    <?php
  }

  
}

function getCoursDatas(){ // recup presents, absents, retards, matiere, groupe du cours

  include '../client-side/connexionBDD.php';

  date_default_timezone_set('Europe/Paris');
  $currentTime = date('H:i:s');
 
  // si il est moins de 12h30
  if ($currentTime < '12:30:00'){ 
    $currentDate = date('Y/m/d')." 00:00:05"; // pour recup cours matin 
  }
  else {
    $currentDate = date('Y/m/d')." 12:31:00"; // pour recup cours aprem
  }

  $stmtCoursDatas =$dbh -> prepare("SELECT datetimeDebut, nomMatiere, nomGroupe, groupe.idGroupe, cours.idCours FROM cours, matiere, groupe WHERE datetimeDebut > '$currentDate' AND cours.idMatiere = matiere.idMatiere AND cours.idGroupe = groupe.idGroupe");

  $donneesCoursDatas = $stmtCoursDatas-> execute(); 
  $stmtCoursDatas->rowCount();
 
  while ($donneesCoursDatas =$stmtCoursDatas->fetch()) {
    $idGroupe = $donneesCoursDatas["idGroupe"];
    $idCours = $donneesCoursDatas["idCours"];

    $stmtCoursPresents =$dbh -> prepare("SELECT DISTINCT coursuser.idUser, heureArrivee, coursuser.idCours FROM groupe, user, cours, coursuser WHERE groupe.idGroupe = cours.idGroupe AND cours.idCours = coursuser.idCours AND groupe.idGroupe = '$idGroupe' AND isProf = 0 AND user.idUser = coursuser.idUser AND coursuser.idCours = '$idCours'");
    $donneesCoursPresents = $stmtCoursPresents-> execute();

    $stmtCoursTotal =$dbh -> prepare("SELECT DISTINCT user.idUser FROM groupeuser, user WHERE user.idUser = groupeuser.idUser AND idGroupe = '$idGroupe' AND isProf = 0");
    $donneesCoursTotal = $stmtCoursTotal-> execute();
    
    $stmtCoursRetards =$dbh -> prepare("SELECT DISTINCT coursuser.idUser, heureArrivee, dateTimeDebut, coursuser.idCours FROM groupe, user, cours, coursuser WHERE groupe.idGroupe = cours.idGroupe AND cours.idCours = coursuser.idCours AND groupe.idGroupe = '$idGroupe' AND isProf = 0 AND user.idUser = coursuser.idUser AND coursuser.idCours = '$idCours' AND heureArrivee > datetimeDebut");
    $donneesCoursRetards = $stmtCoursRetards-> execute();
    ?>

    <section class="compteur">

      <div class="containerCompteur">
        <div class="presents"><?php echo $nbPresents = sprintf("%02d", $stmtCoursPresents-> rowCount()); ?></div>
        <div class="slash">/</div>
        <div class="absents"><?php echo $nbTotal = sprintf("%02d", $stmtCoursTotal-> rowCount()); ?></div>
      </div>

      <div class="titleDatas">
        <h3><?php echo $donneesCoursDatas["nomMatiere"]; ?></h3>
        <h4><?php echo $donneesCoursDatas["nomGroupe"]; ?></h4>
      </div>

      <div class="nbRetards"><?php
        if ($stmtCoursRetards->rowCount() > 1){
          echo $stmtCoursRetards->rowCount()." "."retards";
        } 
        else {
          echo $stmtCoursRetards->rowCount()." "."retard";
        }?>
      </div>
   
    </section>
    <?php
  }

}

function getAbsenteisme(){

  include '../client-side/connexionBDD.php';

  date_default_timezone_set('Europe/Paris');
  $twoWeeksBeforeDate = date('Y/m/d');
  $twoWeeksBeforeDate = strtotime("-10 days", strtotime($twoWeeksBeforeDate));
  $twoWeeksBeforeDate = date("Y/m/d", $twoWeeksBeforeDate);

  $stmtAbsenteisme =$dbh -> prepare("SELECT DISTINCT prenomUser, nomUser, user.idUser, groupe.nomGroupe, cours.idCours, nomMatiere, heureArrivee
  FROM user INNER JOIN groupeuser ON groupeuser.idUser = user.idUser AND user.isProf = 0
  INNER JOIN groupe ON groupe.idGroupe = groupeuser.idGroupe INNER JOIN cours ON cours.idGroupe = groupe.idGroupe AND cours.isEnded = 1
  INNER JOIN matiere ON matiere.idMatiere = cours.idMatiere  LEFT JOIN coursuser ON coursuser.idUser = user.idUser  WHERE (coursuser.idUser IS NULL OR heureArrivee > datetimeDebut) AND  datetimeDebut >= '$twoWeeksBeforeDate' ORDER BY nomUser, prenomUser ASC
  ");

    $donneesAbsenteisme = $stmtAbsenteisme-> execute();   

  if ($stmtAbsenteisme->rowCount() > 0){
    while ($donneesAbsenteisme =$stmtAbsenteisme->fetch()) {
      $nomGroupe = explode(' ',trim($donneesAbsenteisme["nomGroupe"]));
      ?>
       <span class="idUser idUserAbsenteisme<?php echo $donneesAbsenteisme["idUser"]; ?>"><?php echo $donneesAbsenteisme["idUser"]; ?></span>
      <div class="containerAbsenteisme">
       
        <span><?php echo $donneesAbsenteisme["prenomUser"]." ".$donneesAbsenteisme["nomUser"];?></span> 
        <span class="promoAbsenteisme"><?php echo $nomGroupe[0];?></span>
        <span class="matiereAbsenteisme"><?php echo $donneesAbsenteisme["nomMatiere"];?></span> </div> 
      
        <?php
    }

  }
  else {
    ?> <style>
    .alertes{
      display:none;
    }
    </style>
    <?php
  }


}
