<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && $_SESSION["isAdmin"] == 1  && $_SESSION["isActualUser"] == 1)  {

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/filtres.css">
    <title>Filtres</title>
</head>
<body>

<main>

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

    </section> 

    <a href="archives.php?" class="btSearch">Rechercher</a>

</main>

<script src="../../js/calendar.js"></script>
<script src="../../js/sublet.js"></script>
<script src="../../js/filtres.js"></script>
</body>
</html>

<?php }


function getDatas(){

    include '../client-side/connexionBDD.php';

    $stmtDatas =$dbh -> prepare("SELECT datetimeDebut, nomGroupe, idCours FROM cours, groupe WHERE cours.idGroupe = groupe.idGroupe ORDER BY `cours`.`datetimeDebut` DESC");

    $donneesDatas = $stmtDatas-> execute();   

    while ($donneesDatas =$stmtDatas->fetch()) { ?>

    <?php }

}