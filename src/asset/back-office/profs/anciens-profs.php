<?php 
session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anciens professeurs</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/profs.css">
</head>
<body>

    <?php
        include "../../client-side/connexionBDD.php";

        if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="add" && is_numeric($_GET["id"])){
            $id = $_GET['id'];
            $stmt_s = $dbh->prepare("UPDATE user SET isActualUser='1' WHERE idUser='$id'");
            $donnees_s = $stmt_s->execute();
            $_SESSION['error_message'] = "";
            $_SESSION['done_message'] = "L'utilisateur a bien été ajouté.";
        }
        $stmt = $dbh->prepare("SELECT idUser, nomUser, prenomUser FROM user WHERE isProf = 1 AND isActualUser = 0 ORDER by nomUser");
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

  <h1>Anciens profs</h1>

  <?php if ($_SESSION['error_message'] != "" && isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ""){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <main>
        <div id="containerList">
       
          <div class="containerTools">
            <h2 class="hRole">Anciens profs</h2>
            <a href="prof-create.php">Ajouter</a>
            <div class="filtres">
              <input class="search" placeholder="&#xF002;" />
              <div class="filtresSort">
                <span class='sort' data-sort='nomProfs' data-default-order='asc'>Nom</span>
                <span class='sort' data-sort='prenomProfs' data-default-order='asc'>Prénom</span>
              </div>
              <a href="profs.php" class="links">Profs actuels<i class="far fa-arrow-right"></i></a>
            </div>
          </div>
        <ul class="list">
        <?php
            while ($donnees = $stmt->fetch()){
        ?>
 
          <li class="liList">
            <div class="containerProfs">
              <span class="nomProfs"><?php echo $donnees['nomUser'] ?></span> <span class="prenomProfs"><?php echo $donnees['prenomUser'] ?></span>
              <span class="ids"><?php echo $donnees['idUser']?></span>
            </div>
            <div class="containerActions">
              <a href="prof-create.php?action=edit&amp;id=<?php echo $donnees['idUser']?>"><img src="../../../img/Icons/Edit.svg" alt=""></a>
              <a href="#modalWindow" class="linkModal"><i class="fal fa-plus-circle"></i></a>
            </div>

          </li>
  

        <?php
        }
       

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
        </ul>
        </div>

        <a href="anciens-profs.php" class="linksPhone">Profs actuels<i class="far fa-arrow-right"></i></a>

        <div id="modalWindow" class="modal">
            <div class="modal-content">
                <p id='pRetard'>Confirmez-vous l'ajout de <span id="nomProfModal"></span> <span id="prenomProfModal"></span> ? </p>    
              
                <div class="actionBtns">
                    <a href="#"  name="annuler" id="annulerModal" class="btnModal">Annuler</a>
                    <a href="anciens-profs.php?action=add&amp;id=" name="valider" id="validerModal" class="btnModal">Valider</a>
                </div>

                <a href="#" class="modal-close">&times;</a>
            </div>
        </div>
        </main>

    <script src="../../../js/list.js"></script>
    <script src="../../../js/profs.js"></script>
</body>
</html>

<?php

$_SESSION['error_message']="";
$_SESSION['done_message']="";

      }