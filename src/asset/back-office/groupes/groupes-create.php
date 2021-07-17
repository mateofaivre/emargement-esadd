<?php

session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

       include "../../client-side/connexionBDD.php";

       if (isset($_GET['id'])){ 
        $id = $_GET['id'];
    };

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  

        $idPromo = $_GET['idPromo'];

        $stmtElevesNotSelected = $dbh->prepare("SELECT DISTINCT user.idUser, nomUser, prenomUser FROM user, groupeuser, groupe, promo WHERE promo.idPromo = groupe.idPromo AND groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND isProf = 0 AND user.idUser NOT IN (SELECT idUser FROM groupeuser WHERE groupeuser.idGroupe = '$id')");
        $stmtPromosNotSelected = $dbh->prepare("SELECT idPromo, nomPromo FROM promo WHERE idPromo != '$idPromo' ORDER by nomPromo");
        $stmtElevesSelected = $dbh->prepare("SELECT DISTINCT user.idUser, nomUser, prenomUser FROM user, groupeuser, groupe WHERE groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND isProf = 0 AND groupeuser.idGroupe = '$id' ORDER by nomUser");
        $stmtPromosSelected = $dbh->prepare("SELECT idPromo, nomPromo FROM promo WHERE idPromo = '$idPromo' ORDER by nomPromo");
        $donneesElevesNotSelected = $stmtElevesNotSelected->execute();
        $donneesPromosNotSelected = $stmtPromosNotSelected->execute();
        $donneesElevesSelected = $stmtElevesSelected->execute();
        $donneesPromosSelected = $stmtPromosSelected->execute();
    }
    else {
      $stmtAllEleves = $dbh->prepare("SELECT DISTINCT user.idUser, nomUser, prenomUser, nomPromo FROM user, groupe, groupeuser, promo WHERE user.idUser = groupeuser.idUser AND groupeuser.idGroupe = groupe.idGroupe AND groupe.idPromo = promo.idPromo AND isProf = 0 ORDER by nomPromo, nomUser");
      $stmtAllPromos = $dbh->prepare("SELECT promo.idPromo, nomPromo FROM promo ORDER BY nomPromo");
      $donneesAllEleves = $stmtAllEleves->execute();
      $donneesAllPromos = $stmtAllPromos->execute();
    }
   

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groupes</title>
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
        <span class="link-text">Cours</span>
        </a>
      </li> 

    </ul>
  </nav>

  <h1>Groupes</h1>  
    <main class="form-popup" id="form-profs">

    <?php if ($_SESSION['error_message'] != ''){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ''){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <form action="groupes-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo '?action=edit&id='.$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="groupe_nom" name="groupe_nom" placeholder="Nom" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $_GET['groupe']; };
           ?>" required>

            <?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ ?>
            <select id='testSelect1' multiple  name="select_eleves[]" required>
            <?php
                while ($donneesElevesSelected = $stmtElevesSelected->fetch()){
                     $idsUsers[] = $donneesElevesSelected['idUser'];
                    ?> <option value="<?php echo $donneesElevesSelected['idUser']; ?>" selected><?php echo $donneesElevesSelected['nomUser']." ".$donneesElevesSelected['prenomUser']; ?></option>

                <?php }
              $_SESSION['eleves_selected'] = $idsUsers;
                while ($donneesElevesNotSelected = $stmtElevesNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesElevesNotSelected['idUser']; ?>"><?php echo $donneesElevesNotSelected['nomUser']." ".$donneesElevesNotSelected['prenomUser']; ?></option>

               <?php } ?>
            </select>
            <select id='select2'  name="select_promos" required>
            <option value="0" disabled>Promos</option>
            <?php
                while ($donneesPromosSelected = $stmtPromosSelected->fetch()){
                     $idsPromos = $donneesPromosSelected['idPromo'];
                    ?> <option value="<?php echo $donneesPromosSelected['idPromo']; ?>" selected><?php echo $donneesPromosSelected['nomPromo']; ?></option>

                <?php }
              $_SESSION['promos_selected'] = $idsPromos;
                while ($donneesPromosNotSelected = $stmtPromosNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesPromosNotSelected['idPromo']; ?>"><?php echo $donneesPromosNotSelected['nomPromo']; ?></option>

               <?php } ?>
            </select>
            <?php }
            
            
            else { ?>
               
              <select id='testSelect1' multiple  name="select_eleves[]" >
            
           <?php   while ($donneesAllEleves = $stmtAllEleves->fetch()){
                $idsGroupes[] = $donneesAllEleves['idGroupe'];
                ?> <option value="<?php echo$donneesAllEleves['idUser'];; ?>" ><?php echo $donneesAllEleves['nomUser']." ".$donneesAllEleves['prenomUser'];; ?></option> <?php
              }
           ?> </select>

              <select id='select2' name="select_promos" class="firstOption">
              <option value="0" disabled selected >Promos</option>
           <?php   while ($donneesAllPromos = $stmtAllPromos->fetch()){
                $idsPromos = $donneesAllPromos['idPromo'];
               ?> <option value="<?php echo $donneesAllPromos['idPromo']; ?>" ><?php echo $donneesAllPromos['nomPromo']; ?></option>

           <?php }
           ?> </select>
           <?php } ?>

<script>
	document.multiselect('#testSelect1')
		.setCheckBoxClick("checkboxAll", function(target, args) {
		})
		.setCheckBoxClick("1", function(target, args) {
		});


	function enable() {
		document.multiselect('#testSelect1').setIsEnabled(true);
    document.multiselect('#testSelect2').setIsEnabled(true);
	}

	function disable() {
		document.multiselect('#testSelect1').setIsEnabled(false);
    document.multiselect('#testSelect2').setIsEnabled(false);
	}

  document.querySelector('#testSelect1_input').placeholder = "Élèves"
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

    <script src="../../../js/groupes-create.js"></script>
   
</body>
</html>

<?php

    $_SESSION['error_message']="";
    $_SESSION['done_message']="";

}
