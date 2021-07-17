<?php

session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

       include "../../client-side/connexionBDD.php";

       if (isset($_GET['id'])){ 
        $id = $_GET['id'];
    };

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  

        $idDiplome = $_GET['idDiplome'];
        $stmtPromo = $dbh->prepare("SELECT idPromo, nomPromo, dateCreation, idDiplome FROM promo WHERE idPromo = '$id' ORDER BY nomPromo");
        $stmtDiplomeNotSelected = $dbh->prepare("SELECT nomDiplome, diplome.idDiplome FROM diplome, promo WHERE promo.idDiplome = diplome.idDiplome AND diplome.idDiplome != '$idDiplome' ORDER by nomDiplome");
        $stmtDiplomeSelected = $dbh->prepare("SELECT DISTINCT nomDiplome, diplome.idDiplome FROM diplome, promo WHERE promo.idDiplome = diplome.idDiplome AND diplome.idDiplome = '$idDiplome' ORDER BY nomDiplome");
        $donneesPromo = $stmtPromo->execute();
        $donneesPromo = $stmtPromo->fetch();
        $donneesDiplomeNotSelected = $stmtDiplomeNotSelected->execute();  
        $donneesDiplomeSelected = $stmtDiplomeSelected->execute();
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
    <title>Promos</title>
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

  <h1>Promos</h1>
    <main class="form-popup" id="form-profs">

    <?php if ($_SESSION['error_message'] != ''){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ''){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <form action="promos-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo '?action=edit&id='.$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="promo_nom" name="promo_nom" placeholder="Nom" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $_GET['promo']; };
           ?>" required>

            <input type="text" id="date_rentree" name="date_rentree" placeholder="Année de rentrée" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $donneesPromo['dateCreation']; };
                    ?>" required>

            <?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ ?>

            <select id='select2'  name="select_diplome" required>
            <option value="0" disabled>Diplômes</option>
            <?php
                while ($donneesDiplomeSelected = $stmtDiplomeSelected->fetch()){
                     $idsDiplome = $donneesDiplomeSelected['idDiplome'];
                    ?> <option value="<?php echo $donneesDiplomeSelected['idDiplome']; ?>" selected><?php echo $donneesDiplomeSelected['nomDiplome']; ?></option>

                <?php }
              $_SESSION['diplome_selected'] = $idsDiplome;
                while ($donneesDiplomeNotSelected = $stmtDiplomeNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesDiplomeNotSelected['idDiplome']; ?>"><?php echo $donneesDiplomeNotSelected['nomDiplome']; ?></option>

               <?php } ?>
            </select>
          
            <?php }
            
            else { ?>
               
              <select id='select2'   name="select_diplome"  class="firstOption">
              <option value="0" disabled selected >Diplômes</option>
            
           <?php   while ($donneesAllDiplome = $stmtAllDiplome->fetch()){
                $idsDiplome = $donneesAllDiplome['idDiplome'];
                ?> <option value="<?php echo $donneesAllDiplome['idDiplome']; ?>" ><?php echo $donneesAllDiplome['nomDiplome']; ?></option> <?php
              }
           ?> </select>

           <?php } ?>


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

          }
