<?php

session_start();
if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

       include "../../client-side/connexionBDD.php";

       if (isset($_GET['id'])){
        $id = $_GET['id'];
    };

    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){

        $idsPromo = $_GET['idPromo'];

        $stmt_d = $dbh->prepare("SELECT prenomUser, nomUser, nomMatiere FROM user, usermatiere, matiere WHERE user.idUser = usermatiere.idUser AND usermatiere.idMatiere = matiere.idMatiere AND matiere.idMatiere='$id'");
        $stmtProfsNotSelected = $dbh->prepare("SELECT DISTINCT user.idUser, nomUser, prenomUser FROM user, usermatiere, matiere WHERE isProf = 1 AND user.idUser = usermatiere.idUser AND usermatiere.idMatiere = matiere.idMatiere AND user.idUser NOT IN (SELECT usermatiere.idUser FROM matiere, user, usermatiere WHERE user.idUser = usermatiere.idUser AND usermatiere.idMatiere = '$id') ORDER by nomUser");
        $stmtPromosNotSelected = $dbh->prepare("SELECT DISTINCT promo.idPromo, nomPromo FROM matiere, matierepromo, promo WHERE matiere.idMatiere = matierepromo.idMatiere AND matierepromo.idPromo = promo.idPromo AND promo.idPromo NOT IN (SELECT matierepromo.idPromo FROM matierepromo, promo WHERE idMatiere = '$id' ) ORDER by nomPromo");
        $stmtProfsSelected = $dbh->prepare("SELECT user.idUser, prenomUser, nomUser, nomMatiere FROM user, usermatiere, matiere WHERE user.idUser = usermatiere.idUser AND usermatiere.idMatiere = matiere.idMatiere AND matiere.idMatiere='$id' ORDER by nomUser");
        $stmtPromosSelected = $dbh->prepare("SELECT DISTINCT promo.idPromo, nomPromo FROM matierepromo, promo WHERE matierepromo.idPromo = promo.idPromo  AND idMatiere = '$id' ORDER by nomPromo");
        $donnees_d = $stmt_d->execute();
        $donneesProfsNotSelected = $stmtProfsNotSelected->execute();
        $donneesPromosNotSelected = $stmtPromosNotSelected->execute();
        $donneesProfsSelected = $stmtProfsSelected->execute();
        $donneesPromosSelected = $stmtPromosSelected->execute();
    }
    else {
      $stmtAllProfs = $dbh->prepare("SELECT user.idUser, prenomUser, nomUser FROM user WHERE isProf = 1 ORDER by nomUser");
      $stmtAllPromos = $dbh->prepare("SELECT promo.idPromo, nomPromo FROM promo ORDER BY nomPromo");
      $donneesAllProfs = $stmtAllProfs->execute();
      $donneesAllPromos = $stmtAllPromos->execute();
    }
   

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/matieres-create.css">
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

  <h1>Matière</h1>
    <main class="form-popup" id="form-profs">

    <?php if ($_SESSION['error_message'] != ''){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ''){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

        <form action="matiere-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo '?action=edit&id='.$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="matiere_nom" name="matiere_nom" placeholder="Nom" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo $_GET['matiere']; };
           ?>" required>

            <?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ ?>
            <select id='testSelect1' multiple  name="select_profs[]" required>
            <?php
                while ($donneesProfsSelected = $stmtProfsSelected->fetch()){
                     $idsUsers[] = $donneesProfsSelected['idUser'];
                    ?> <option value="<?php echo $donneesProfsSelected['idUser']; ?>" selected><?php echo $donneesProfsSelected['nomUser']." ".$donneesProfsSelected['prenomUser']; ?></option>

                <?php }
              $_SESSION['profs_selected'] = $idsUsers;
                while ($donneesProfsNotSelected = $stmtProfsNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesProfsNotSelected['idUser']; ?>"><?php echo $donneesProfsNotSelected['nomUser']." ".$donneesProfsNotSelected['prenomUser']; ?></option>

               <?php } ?>
            </select>
            <select id='testSelect2' multiple  name="select_promos[]" required>
            <?php
                while ($donneesPromosSelected = $stmtPromosSelected->fetch()){
                     $idsPromos[] = $donneesPromosSelected['idPromo'];
                    ?> <option value="<?php echo $donneesPromosSelected['idPromo']; ?>" selected><?php echo $donneesPromosSelected['nomPromo']; ?></option>

                <?php }
              $_SESSION['promos_selected'] = $idsPromos;
                while ($donneesPromosNotSelected = $stmtPromosNotSelected->fetch()){

                   ?> <option value="<?php echo $donneesPromosNotSelected['idPromo']; ?>"><?php echo $donneesPromosNotSelected['nomPromo']; ?></option>

               <?php } ?>
            </select>
            <?php }
            
            
            else { ?>
              <select id='testSelect1' multiple  name="select_profs[]" >
           <?php   while ($donneesAllProfs = $stmtAllProfs->fetch()){
                $idsUsers[] = $donneesAllProfs['idUser'];
               ?> <option value="<?php echo $donneesAllProfs['idUser']; ?>" ><?php echo $donneesAllProfs['nomUser']." ".$donneesAllProfs['prenomUser']; ?></option>

           <?php }
           ?> </select>

              <select id='testSelect2' multiple  name="select_promos[]" >
           <?php   while ($donneesAllPromos = $stmtAllPromos->fetch()){
                $idsPromos[] = $donneesAllPromos['idPromo'];
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
    document.multiselect('#testSelect2')
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

  document.querySelector('#testSelect2_input').placeholder = "Promos"
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

}
