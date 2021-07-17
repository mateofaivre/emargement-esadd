<?php

session_start();


       include "../../client-side/connexionBDD.php";

       if (isset($_GET['id'])){ 
        $id = $_GET['id'];
    };

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  

       
        $stmtDiplomeSelected = $dbh->prepare("SELECT idDiplome, nomDiplome, dureeDiplome FROM diplome WHERE idDiplome = '$id' ORDER BY nomDiplome");
        $stmtDiplomeNotSelected = $dbh->prepare("SELECT idDiplome, nomDiplome, dureeDiplome FROM diplome WHERE idDiplome != '$id' ORDER BY nomDiplome");
        $donneesDiplomeSelected = $stmtDiplomeSelected->execute();
        $donneesDiplomeNotSelected = $stmtDiplomeNotSelected->execute();  
    }
    else {
      $stmtAllDiplome = $dbh->prepare("SELECT nomDiplome, diplome.idDiplome FROM diplome ORDER BY nomDiplome");
      $donneesAllDiplome = $stmtAllDiplome->execute();
    }
   

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diplômes</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/groupes-create.css">
    <link rel="stylesheet" href="../../../css/multiselect.css">
    <script src="../../../js/multiselect.min.js"></script>
</head>
<body>

<nav class="navbar">
    <ul class="navbar-nav">
      <li class="logo">
        <a href="#" class="nav-link">
        <?php if (isset($_SESSION['photoUser'])){
            ?>  <img class="" src="../../../../images-users/<?php echo $_SESSION['photoUser'] ?>"  alt=""> <?php
          }
          else { ?>
            <span class="link-text logo-text" > <?php echo $_SESSION['name'];?></span>
          <?php  } ?>
        </a>
      </li>

      <li class="nav-item">
        <a href="../home.php" class="nav-link">
        <img src="../../../img/Icons/HomeOrange.svg" alt="">
        <span class="link-text">Accueil</span>
        </a>

      </li>

      <li class="nav-item">
        <a href="../archives.php" class="nav-link">
        <img src="../../../img/Icons/FolderOrange.svg" alt="">
        <span class="link-text">Archives</span>
        </a>
      </li>

      <hr class="separator">

      <li class="nav-item">
        <a href="../profs/profs.php" class="nav-link">
        <img src="../../../img/Icons/MaletteOrange.svg" alt="">
        <span class="link-text">Professeurs</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../eleves/eleves.php" class="nav-link">
        <img src="../../../img/Icons/UserOrange.svg" alt="">
        <span class="link-text">Élèves</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../matieres/matieres.php" class="nav-link">
        <img src="../../../img/Icons/ParamsOrange.svg" alt="">
        <span class="link-text">Matières</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../groupes/groupes.php" class="nav-link">
        <img src="../../../img/Icons/2UsersOrange.svg" alt="">
        <span class="link-text">Groupes</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../promos/promos.php" class="nav-link">
        <img src="../../../img/Icons/3UsersOranges.svg" alt="">
        <span class="link-text">Promos</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../diplomes/diplomes.php" class="nav-link">
        <img src="../../../img/Icons/DiplomeOrange.svg" alt="">
        <span class="link-text">Diplômes</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="../droits/droits.php" class="nav-link">
        <img src="../../../img/Icons/profile.svg" alt="">
        <span class="link-text">Droits</span>
        </a>
      </li>

      <hr class="separator">

      <li class="nav-item">
        <a href="../../../../../workshop-test" class="nav-link">
        <img src="../../../img/Icons/books.svg" alt="">
        <span class="link-text">Feuilles</span>
        </a>
      </li> 

    </ul>
  </nav>

  <h1>Diplômes</h1>
    <main class="form-popup" id="form-profs">

    <?php if ($_SESSION['error_message'] != ''){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ''){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <form action="diplomes-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo '?action=edit&id='.$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="promo_nom" name="diplome_nom" placeholder="Nom" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $_GET['diplome']; };
           ?>" required>

            <input type="text" id="date_rentree" name="duree_diplome" placeholder="Durée du diplôme" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ if($_GET['dureeDiplome'] > 1){
                echo $_GET['dureeDiplome']." ans"; }
            else {
                echo $_GET['dureeDiplome']." an";
            }};
                    ?>" required>

            <input type="submit" id="submitBtn" name="submitBtn" value="<?php
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                echo "Mettre à jour";
            }
            else{
                echo "Ajouter"; 
            }
            ?>">
        </form>

    </main>

    <script src="../../../js/groupes-create.js"></script>
   
</body>
</html>

<?php

    $_SESSION['error_message']="";
    $_SESSION['done_message']="";
