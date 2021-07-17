<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && $_SESSION["isAdmin"] == 1 && $_SESSION["isActualUser"] == 1)  {

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../css/archives.css">
    <title>Archives</title>
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
            <a href="./profs/profs.php" class="nav-link">
            <img src="../../img/Icons/MaletteOrange.svg" alt="">
            <span class="link-text">Professeurs</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="./eleves/eleves.php" class="nav-link">
            <img src="../../img/Icons/UserOrange.svg" alt="">
            <span class="link-text">Élèves</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="./matieres/matieres.php" class="nav-link">
            <img src="../../img/Icons/ParamsOrange.svg" alt="">
            <span class="link-text">Matières</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="./groupes/groupes.php" class="nav-link">
            <img src="../../img/Icons/2UsersOrange.svg" alt="">
            <span class="link-text">Groupes</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="./promos/promos.php" class="nav-link">
            <img src="../../img/Icons/3UsersOranges.svg" alt="">
            <span class="link-text">Promos</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="./diplomes/diplomes.php" class="nav-link">
            <img src="../../img/Icons/DiplomeOrange.svg" alt="">
            <span class="link-text">Diplômes</span>
            </a>
        </li>

        <li class="nav-item">
        <a href="./droits/droits.php" class="nav-link">
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
        <h1>Archives</h1>

        <form method="POST" class="containerForm">

            <div class="ligne1"><h3>Date</h3><h3>Période</h3>  <div class="containerBtFiltrerPC"><button type="button" name="btFiltrerPC" class="btFiltrerPC" id="btFiltrerPC">Filtrer <i class="fal fa-sliders-h"></i></button> </div></div>

            <?php getDatas(); ?>
        
        </form>

        <div class="containerFiltrerPhone">
        <button type="button" name="btFiltrerphone" class="btFiltrerPhone">Filtrer <i class="fal fa-sliders-h"></i></button>
        </div>

    <div class="containerCalendarPromo">
            <i class="far fa-times"></i>
        <section class="containerCalendar">
            <fieldset>
            <div class="input" id="language">
                <label for="lang">Language:</label>
                <select id="lang">
                <option value="fr">Français</option>
                
                <option value="es">Spanish</option>
                </select>
            </div>

            <div class="input">
                <select id="month">
                <option value="0">Janvier</option>    
                <option value="1">Février</option>
                <option value="2">Mars</option>
                <option value="3">Avril</option>
                <option value="4">Mai</option>
                <option value="5">Juin</option>
                <option value="6">Juillet</option>
                <option value="7">Août</option>
                <option value="8">Septembre</option>
                <option value="9">Octobre</option>
                <option value="10">Novembre</option>
                <option value="11">Décembre</option>
                </select>
                
                <input id="year" type="number" min="1900" max="2100" step="1" value="2021">
            </div>
            
            <div class="input" id="weekStart">
                <label for="offset">Week Start:</label>
                <select id="offset">
                <option value="0">Sunday</option>
                <option value="1" selected>Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                </select>
            </div>
            </fieldset>

            <div id="calendar">
            <div class="labels"></div>
            <div class="dates"></div>
            </div>
        </section>

        <section class="searchBy">

        <h2>Rechercher par promo</h2>


        <div class="containerCheckboxs">
            <?php getPromos(); ?>
        </div>

        </section> 

        <a href="archives.php?" class="btSearch disabled">Rechercher</a>
        <a href="archives.php?" class="allFeuilles"><i class="far fa-arrow-left"></i>Voir toutes les feuilles</a>

    </div>

    </main>

  
    <script src="../../js/calendar.js"></script>
    <script src="../../js/sublet.js"></script>
    <script src="../../js/filtres.js"></script>
    <script src="../../js/list.js"></script>
</body>
</html>


<?php

}

function executeFetch($stmtParam, $promo){
        
    $donneesDatas = $stmtParam-> execute();   

    while ($donneesDatas =$stmtParam->fetch()) { ?>
    <?php 
        $date = new DateTime($donneesDatas["datetimeDebut"]);
        $dateDay = $date->format('d/m/Y');
        $dateTime = $date-> format('H:i');
        if ($dateTime < "12:30" && $dateTime > "00:00"){
            $periode = "Matin";
        }
        if ($dateTime > "12:30" && $dateTime < "23:59") {
            $periode  = "Après-midi";   
        }
    ?>
        <div class="ligne">
            <div class="ligneDate">
                <div class="date"><?php echo $dateDay; ?> </div>
                <div class="groupe"><?php echo $donneesDatas["nomGroupe"]; ?></div>
            </div>
            <div class="lignePeriode">
                <div class="periode"><?php echo $periode; ?> </div>
                <a href="feuille.php?idCours=<?php echo $donneesDatas["idCours"]?>&idGroupe=<?php echo $donneesDatas['idGroupe'];?>">Feuille de présence <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
    }
    if ($stmtParam->rowCount() == 0){ ?>
        <style>
            /* .ligne1 h3 {
                display:none;
            } */
        </style>
       <p> Promo <?php echo $promo ?> : Il n'y a pas de résultats pour ces critères.</p> <?php
    }
}


function getDatas(){

    include '../client-side/connexionBDD.php';

    date_default_timezone_set('Europe/Paris');
    $date15daysBefore = date('Y-m-d');
    $date15daysBefore = strtotime("-15 days", strtotime( $date15daysBefore));
    $date15daysBefore = date('Y-m-d',  $date15daysBefore);

    if(count($_GET)) {
        ?> 
        <style>
            .containerFiltrer {
                display:none;
            }
            .allFeuilles{
                display:block;
            }
        </style>
        <?php

        if (isset($_GET["jour"])){
            $jour = $_GET["jour"];
        }
        if (isset($_GET["mois"])){
            $mois = $_GET["mois"];
        }
        if (isset($_GET["annee"])){
            $annee = $_GET["annee"];
        }
        if (isset($_GET["promo"])){
            $promo = $_GET["promo"];
        }
        
        if ( (isset($jour) && isset($mois) && isset($annee) && isset($promo)) || (isset($jour) && isset($mois) && isset($annee)) ){
            $var = $jour;
        }
        else if (isset($promo)){
            $var = $promo;
        }

            for ($i=0; $i < count($var); $i++) { 

                if (isset($jour) && isset($mois) && isset($annee)){
                    $time = strtotime($annee[$i].'-'.$mois[$i].'-'.$jour[$i]);
                    ?> <h4><?php echo date('d/m/Y',$time); ?></h4><?php
                    $dateJour = date('Y-m-d',$time);
                    $dateJourSuivant = strtotime("+1 day", strtotime($dateJour));
                    $dateJourSuivant = date('Y-m-d', $dateJourSuivant);

                    if (!isset($promo)){
                        echo 'pas promo';
                        $stmtDatas =$dbh -> prepare("SELECT datetimeDebut, nomGroupe, idCours, datetimeDebut, groupe.idGroupe FROM cours, groupe WHERE cours.idGroupe = groupe.idGroupe AND datetimeDebut > '$dateJour' AND isEnded = 1 AND datetimeDebut < '$dateJourSuivant'  ORDER BY `cours`.`datetimeDebut` DESC");
                    }
                    else {
                        for ($iPromo=0; $iPromo < count($promo); $iPromo++){
                            $stmtDatas =$dbh -> prepare("SELECT DISTINCT datetimeDebut, nomGroupe, idCours, datetimeDebut, nomPromo, groupe.idGroupe FROM cours, groupe, promo WHERE cours.idGroupe = groupe.idGroupe AND groupe.idPromo = promo.idPromo AND datetimeDebut > '$dateJour'  AND isEnded = 1 AND datetimeDebut < '$dateJourSuivant' AND nomPromo = '$promo[$iPromo]' ORDER BY `cours`.`datetimeDebut` DESC");
                            executeFetch($stmtDatas, $promo[$iPromo]);
                        }
                    }
                }
                else {
                    for ($iPromo=0; $iPromo < count($promo); $iPromo++){
                        $stmtDatas =$dbh -> prepare("SELECT DISTINCT datetimeDebut, nomGroupe, idCours, datetimeDebut, nomPromo FROM cours, groupe, promo WHERE cours.idGroupe = groupe.idGroupe AND groupe.idPromo = promo.idPromo AND nomPromo = '$promo[$iPromo]'  AND isEnded = 1 AND datetimeDebut > '$date15daysBefore' ORDER BY `cours`.`datetimeDebut` DESC");
                        executeFetch($stmtDatas, $promo[$iPromo]);
                    }
                }
            };

    }
    else{
        $stmtDatas =$dbh -> prepare("SELECT datetimeDebut, nomGroupe, idCours, groupe.idGroupe FROM cours, groupe WHERE cours.idGroupe = groupe.idGroupe  AND isEnded = 1  AND datetimeDebut > '$date15daysBefore' ORDER BY `cours`.`datetimeDebut` DESC");
        $promo = 0;
        executeFetch($stmtDatas, $promo);
    }

    

}

function getPromos(){

    include '../client-side/connexionBDD.php';

    $stmtPromos =$dbh -> prepare("SELECT nomPromo FROM promo ORDER BY `promo`.`nomPromo` ASC");

    $donneesPromos = $stmtPromos-> execute();   

    while ($donneesPromos =$stmtPromos->fetch()) { ?>

        <label class="checkboxRow"><?php echo $donneesPromos["nomPromo"]?><input type="checkbox"><span class="checkmark"></span></label>
    <?php }
}