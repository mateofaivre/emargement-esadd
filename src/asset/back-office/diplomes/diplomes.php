<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diplômes</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/matieres.css">
</head>
<body>

    <?php
        include "../../client-side/connexionBDD.php";

        if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
          $id = $_GET['id'];           

              $stmtUpdatePromo = $dbh->prepare("UPDATE promo SET idDiplome=NULL WHERE idDiplome='$id'");
              $donneesUpdatePromo = $stmtUpdatePromo->execute();

          $stmtDeleteDiplome = $dbh->prepare("DELETE FROM diplome WHERE idDiplome='$id'");
          $donneesDeleteDiplome = $stmtDeleteDiplome->execute();
          $_SESSION['error_message'] = "";
          $_SESSION['done_message'] = "Le diplôme a bien été supprimé.";
        }

            $stmt = $dbh->prepare("SELECT idDiplome, nomDiplome, dureeDiplome FROM diplome ORDER by nomDiplome ASC");
            $donnees = $stmt->execute();
            
    ?>

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

<?php if (isset($_SESSION['error_message']) && isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if (isset($_SESSION['done_message'])){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

      <style>
        .liList {
          display:flex;
          flex-direction: row;
          justify-content: space-between;
        }
      </style>

        <main>
        <div id="containerList">
       
          <div class="containerTools">
            <h2 class="hRole">Diplômes</h2>
            <a href="diplomes-create.php">Ajouter</a>
            <div class="filtres">
                <input class="search" placeholder="&#xF002;" />
                <div class="filtresSort">
                  <!-- <h3>Trier par :</h3> -->
                  <span class='sort' data-sort='nomDiplomes' data-default-order='asc'>Diplômes</span>
                </div>
              </div>
          </div>
        <ul class="list">

        <?php
            while ($donnees = $stmt->fetch()){
              $idPromoGroupe = $donnees['idDiplome'];
              $stmtGroupe = $dbh -> prepare("SELECT groupe.idPromo, groupe.idGroupe FROM promo, groupe WHERE groupe.idPromo = promo.idPromo AND promo.idPromo = '$idPromoGroupe'");
              $donneesGroupe = $stmtGroupe->execute();
        ?>                                               

            
            <li class="liList">
              <div class="containerDiplomes nomDiplomes">
                <?php echo $donnees['nomDiplome']?>
                <span class="ids"><?php echo $donnees['idDiplome']?></span>
              </div>
              <div class="containerActions">
                <a href="diplomes-create.php?action=edit&amp;id=<?php echo $donnees['idDiplome'];?>&diplome=<?php echo $donnees['nomDiplome'];?>&dureeDiplome=<?php echo $donnees['dureeDiplome'] ?>"><img src="../../../img/Icons/Edit.svg" alt=""></a>
                    <a href="#modalWindow" class="linkModal"><img src="../../../img/Icons/croixRouge.svg" alt=""></a>
              </div>
            </li>
 
           

            
        <?php
      
      }
        

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
   
      </ul>
      </div>

      <div id="modalWindow" class="modal">
            <div class="modal-content">
                <p>Confirmez-vous la suppression de <span id="nomDiplomeModal"></span> ? </p>    
              
                <div class="actionBtns">
                    <a href="#"  name="annuler" id="annulerModal" class="btnModal">Annuler</a>
                    <a href="diplomes.php?action=delete&amp;id=" name="valider" id="validerModal" class="btnModal">Valider</a>
                </div>

                <a href="#" class="modal-close">&times;</a>
            </div>
        </div>

      </main>

      <script src="../../../js/list.js"></script>
      <script src="../../../js/diplomes.js"></script>

</body>
</html>

<?php

$_SESSION['error_message']="";
$_SESSION['done_message']="";