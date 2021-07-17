<?php 
session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/matieres.css">
</head>
<body>

    <?php
        include "../../client-side/connexionBDD.php";

        if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
          $id = $_GET['id'];
          $stmtMatierePromo = $dbh->prepare("DELETE FROM matierepromo WHERE idMatiere='$id'");
          $donneesMatierePromo = $stmtMatierePromo->execute();
          $stmtUserMatiere = $dbh->prepare("DELETE FROM usermatiere WHERE idMatiere='$id'");
          $donneesUserMatiere = $stmtUserMatiere->execute();
          $stmtMatiere = $dbh->prepare("DELETE FROM matiere WHERE idMatiere='$id'");
          $donneesMatiere = $stmtMatiere->execute();
          $_SESSION['error_message'] = "";
          $_SESSION['done_message'] = "La matière a bien été supprimée.";
        }

            $stmt = $dbh->prepare("SELECT prenomUser, nomUser, nomMatiere, matiere.idMatiere FROM user, usermatiere, matiere WHERE user.idUser = usermatiere.idUser AND usermatiere.idMatiere = matiere.idMatiere AND nomUser != 'Super' ORDER by nomMatiere");
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

<h1>Matières</h1>

<?php if (isset($_SESSION['error_message']) && isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if (isset($_SESSION['done_message'])){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <main>
        <div id="containerList">
       
          <div class="containerTools">
            <h2 class="hRole">Matières</h2>
            <h2 class="hRole">Professeurs</h2>
            <a href="matiere-create.php">Ajouter</a>
            <div class="filtres">
                <input class="search" placeholder="&#xF002;" />
                <div class="filtresSort">
                  <span class='sort' data-sort='nomMatieres' data-default-order='asc'>Matières</span>
                  <span class='sort' data-sort='nomProfs' data-default-order='asc'>Profs</span>
                </div>

                <a href="../groupes/groupes.php" class="links">Groupes<i class="far fa-arrow-right"></i></a>
              </div>
          </div>
        <ul class="list">
        <?php
            while ($donnees = $stmt->fetch()){

              $idMatiere = $donnees['idMatiere'];
              $stmtPromo = $dbh->prepare("SELECT idPromo FROM matierepromo WHERE idMatiere = '$idMatiere'");
              $donneesPromo = $stmtPromo->execute();
              
        ?>

            <li class="liList">
            <div class="containerMatieres nomMatieres">
            <?php echo $donnees['nomMatiere']?>
            <span class="ids"><?php echo $donnees['idMatiere']?></span>
              </div>
              <div class="containerProfs">
                <span class="nomProfs"><?php echo $donnees['nomUser'] ?></span> <span class="prenomProfs"><?php echo $donnees['prenomUser'] ?></span>
              </div>
              <div class="containerActions">
              <a href="matiere-create.php?action=edit&amp;id=<?php echo $donnees['idMatiere']?>&matiere=<?php echo $donnees['nomMatiere'];while ($donneesPromo= $stmtPromo->fetch()){
            ?>&idPromo[]=<?php echo $donneesPromo['idPromo']; 
            } ?>"><img src="../../../img/Icons/Edit.svg" alt=""></a>
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
                <p>Confirmez-vous la suppression de <span id="nomMatiereModal"></span> ? </p>    
              
                <div class="actionBtns">
                    <a href="#"  name="annuler" id="annulerModal" class="btnModal">Annuler</a>
                    <a href="matieres.php?action=delete&amp;id=" name="valider" id="validerModal" class="btnModal">Valider</a>
                </div>

                <a href="#" class="modal-close">&times;</a>
            </div>
        </div>
       

        </main>
   
        <script src="../../../js/list.js"></script>
        <script src="../../../js/matieres.js"></script>
</body>
</html>

<?php

$_SESSION['error_message']="";
$_SESSION['done_message']="";

      }