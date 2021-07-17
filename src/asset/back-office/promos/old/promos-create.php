<?php

session_start();


       include "../../client-side/connexionBDD.php";

       if (isset($_GET['id'])){ 
        $id = $_GET['id'];
    };

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  

        $idGroupe[] = $_GET['idGroupe'];
        $stmtPromo = $dbh->prepare("SELECT idPromo, nomPromo, dateCreation FROM promo WHERE idPromo = '$id' ");
        $stmtGroupesNotSelected = $dbh->prepare("SELECT nomGroupe, groupe.idGroupe FROM groupe  EXCEPT SELECT nomGroupe, groupe.idGroupe FROM groupe, promo WHERE groupe.idPromo = promo.idPromo AND groupe.idPromo = '$id' ORDER by nomGroupe");
        $stmtGroupesSelected = $dbh->prepare("SELECT nomGroupe, groupe.idGroupe FROM groupe, promo WHERE groupe.idPromo = promo.idPromo AND groupe.idPromo = '$id' ORDER by nomGroupe");
        $donneesPromo = $stmtPromo->execute();
        $donneesPromo = $stmtPromo->fetch();
        $donneesGroupesNotSelected = $stmtGroupesNotSelected->execute();  
        $donneesGroupesSelected = $stmtGroupesSelected->execute();
    }
    else {
      $stmtAllGroupes = $dbh->prepare("SELECT DISTINCT nomGroupe, groupe.idGroupe FROM groupe ORDER BY nomGroupe");
      $donneesAllGroupes = $stmtAllGroupes->execute();
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
          <img class="link-text logo-text" src="../images-users/<?php echo $_SESSION['photoUser'] ?>" style="width:3rem;" alt="">
          <span class="link-text logo-text" > <?php echo $_SESSION['name'];?></span>
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

    </ul>
  </nav>

  <h1>Promos</h1>
    <main class="form-popup" id="form-profs">

    <?php if (isset($_SESSION['error_message'])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if (isset($_SESSION['done_message'])){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <form action="promos-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo '?action=edit&id='.$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="promo_nom" name="promo_nom" placeholder="Nom" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $_GET['promo']; };
           ?>" required>

            <input type="text" id="date_rentree" name="date_rentree" placeholder="Date de rentrée" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $donneesPromo['dateCreation']; };
                    ?>" required>

            <?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ ?>
            <select id='testSelect1' multiple  name="select_groupes[]" required>
            <?php
                while ($donneesGroupesSelected = $stmtGroupesSelected->fetch()){
                     $idsGroupes[] = $donneesGroupesSelected['idGroupe'];
                    ?> <option value="<?php echo $donneesGroupesSelected['idGroupe']; ?>" selected><?php echo $donneesGroupesSelected['nomGroupe']; ?></option>

                <?php }
              $_SESSION['groupes_selected'] = $idsGroupes;
                while ($donneesGroupesNotSelected = $stmtGroupesNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesGroupesNotSelected['idGroupe']; ?>"><?php echo $donneesGroupesNotSelected['nomGroupe']; ?></option>

               <?php } ?>
            </select>
          
            <?php }
            
            else { ?>
               
              <select id='testSelect1' multiple  name="select_groupes[]" >
            
           <?php   while ($donneesAllGroupes = $stmtAllGroupes->fetch()){
                $idsGroupes[] = $donneesAllGroupes['idGroupe'];
                ?> <option value="<?php echo $donneesAllEleves['idGroupe']; ?>" ><?php echo $donneesAllGroupes['nomGroupe']; ?></option> <?php
              }
           ?> </select>

           <?php } ?>

<script>
	document.multiselect('#testSelect1')

	function enable() {
		document.multiselect('#testSelect1').setIsEnabled(true);
    document.multiselect('#testSelect2').setIsEnabled(true);
	}

	function disable() {
		document.multiselect('#testSelect1').setIsEnabled(false);
    document.multiselect('#testSelect2').setIsEnabled(false);
	}

  document.querySelector('#testSelect1_input').placeholder = "Groupes"
</script>



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
   
</body>
</html>

<?php

    $_SESSION['error_message']="";
    $_SESSION['done_message']="";
