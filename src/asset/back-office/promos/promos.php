<?php 
session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promos</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/matieres.css">
</head>
<body>

    <?php
        include "../../client-side/connexionBDD.php";

        if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
          $id = $_GET['id'];

          if (isset($_GET["idGroupe"])){
            $idsGroupesDelete=  [];
            for ($l=0; $l < count($_GET['idGroupe']); $l++) { 
              $idsGroupesDelete[] = $_GET["idGroupe"][$l];
            }

            for ($i=0; $i < count($idsGroupesDelete); $i++) { 
              $stmtGroupePromo = $dbh->prepare("UPDATE groupe SET idPromo=NULL WHERE idGroupe='$idsGroupesDelete[$i]'");
              $donneesGroupePromo = $stmtGroupePromo->execute();
            }
          }
         
          $stmtDeletePromo = $dbh->prepare("DELETE FROM promo WHERE idPromo='$id'");
          $donneesDeletePromo = $stmtDeletePromo->execute();
          $_SESSION['error_message'] = "";
          $_SESSION['done_message'] = "La promo a bien été supprimée.";
        }

            $stmt = $dbh->prepare("SELECT nomPromo, promo.idPromo, diplome.idDiplome, diplome.nomDiplome FROM promo, diplome WHERE diplome.idDiplome = promo.idDiplome ORDER by nomPromo");
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

<h1>Promos</h1>

<?php if (isset($_SESSION['error_message']) && isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if (isset($_SESSION['done_message'])){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <main>
        <div id="containerList">
       
          <div class="containerTools">
            <h2 class="hRole">Promos</h2>
            <h2 class="hRole">Diplômes</h2>
            <a href="promos-create.php">Ajouter</a>
            <div class="filtres">
                <input class="search" placeholder="&#xF002;" />
                <div class="filtresSort">
                  <span class='sort' data-sort='nomPromos' data-default-order='asc'>Promos</span>
                  <span class='sort' data-sort='nomDiplomes' data-default-order='asc'>Diplômes</span>
                </div>
              </div>
          </div>
        <ul class="list">

        <?php
            while ($donnees = $stmt->fetch()){
              $idPromoGroupe = $donnees['idPromo'];
              $stmtGroupe = $dbh -> prepare("SELECT groupe.idPromo, groupe.idGroupe FROM promo, groupe WHERE groupe.idPromo = promo.idPromo AND promo.idPromo = '$idPromoGroupe'");
             
        ?>                                               

          <li class="liList">
            <div class="containerPromos nomPromos">
              <?php echo $donnees['nomPromo']?>
              <span class="ids"><?php echo $donnees['idPromo']?></span>
            </div>
            <div class="containerDiplomes nomDiplomes">
              <?php echo $donnees['nomDiplome']?>
            </div>
            <div class="containerActions">
              <a href="promos-create.php?action=edit&amp;id=<?php echo $donnees['idPromo'];?>&promo=<?php echo $donnees['nomPromo'];?>&idDiplome=<?php echo $donnees['idDiplome'] ?>"><img src="../../../img/Icons/Edit.svg" alt=""></a>
              <a href="#modalWindow" class="linkModal"><img src="../../../img/Icons/croixRouge.svg" alt=""></a>
            </div>

          </li>
            
             

            
        <?php
        //nettoyer tab
        $idsGroupes = array();
        $nomsGroupes = array();
      
      }
        

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
   
        </ul>
        </div>

        <div id="modalWindow" class="modal">
            <div class="modal-content">
                <p>Confirmez-vous la suppression de <span id="nomPromoModal"></span> ? </p>    
              
                <div class="actionBtns">
                    <a href="#"  name="annuler" id="annulerModal" class="btnModal">Annuler</a>
                    <a href="promos.php?action=delete&amp;id=" name="valider" id="validerModal" class="btnModal">Valider</a>
                </div>

                <a href="#" class="modal-close">&times;</a>
            </div>
        </div>

        </main>

      <script src="../../../js/list.js"></script>
      <script src="../../../js/promos.js"></script>
</body>
</html>

<?php

$_SESSION['error_message']="";
$_SESSION['done_message']="";

    }