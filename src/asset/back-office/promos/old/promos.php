<?php 
session_start();

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
          $stmtMatierePromo = $dbh->prepare("DELETE FROM matierepromo WHERE idMatiere='$id'");
          $donneesMatierePromo = $stmtMatierePromo->execute();
          $stmtUserMatiere = $dbh->prepare("DELETE FROM usermatiere WHERE idMatiere='$id'");
          $donneesUserMatiere = $stmtUserMatiere->execute();
          $stmtMatiere = $dbh->prepare("DELETE FROM matiere WHERE idMatiere='$id'");
          $donneesMatiere = $stmtMatiere->execute();
          $_SESSION['error_message'] = "";
          $_SESSION['done_message'] = "La matière a bien été supprimée.";
        }

            $stmt = $dbh->prepare("SELECT nomPromo, promo.idPromo FROM promo ORDER by nomPromo");
            $donnees = $stmt->execute();
            
    ?>

<nav class="navbar">
    <ul class="navbar-nav">
      <li class="logo">
        <a href="#" class="nav-link">
          <?php if (isset($_SESSION['photoUser'])){
            ?>  <img class="link-text logo-text" src="../images-users/<?php echo $_SESSION['photoUser'] ?>"  alt=""> <?php
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
      
    </ul>
  </nav>

<h1>Promos</h1>

<?php if (isset($_SESSION['error_message']) && isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="delete" && is_numeric($_GET["id"])){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if (isset($_SESSION['done_message'])){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>

    <table class="tableAll" id="table-matieres">
        <tr>
            <th>Promo</th>
            <th>Groupe(s)</th>
            <th><a href="promos-create.php">Ajouter +</a></th>
        </tr> 

        <?php
            while ($donnees = $stmt->fetch()){

              $idPromo = $donnees['idPromo'];
              $stmtGroupe = $dbh->prepare("SELECT nomGroupe, groupe.idGroupe, promo.idPromo FROM promo, groupe WHERE promo.idPromo = groupe.idPromo AND promo.idPromo = '$idPromo' ORDER by nomGroupe");
              $donneesGroupe = $stmtGroupe->execute();
            // $nomsPromos = $donnees['nomPromo'];
            // $idsPromos[] = $donnees['idPromo'];
            // $idsGroupes[] = $donnees['idGroupe'];
            // $nomsGroupes[] = $donnees['nomGroupe'];
              
        ?>                                               

            <tr>
              <td><?php echo $donnees['nomPromo']?></td>

            <?php  while ($donneesGroupe = $stmtGroupe->fetch()){
               $idsGroupes[] = $donneesGroupe['idGroupe'];
              $nomsGroupes[] = $donneesGroupe['nomGroupe'];
            } 

            // print_r($idsGroupes);
            // print_r($nomsGroupes);
?>
              <td style="width: 40%"><?php for ($i=0; $i < count($nomsGroupes); $i++) { 
                if (count($nomsGroupes) > 1 && $i != (count($nomsGroupes)-1)){
                  echo $nomsGroupes[$i].", ";
                }
                else {
                  echo $nomsGroupes[$i];
                }
                
              } ?></td>
              <td><a href="promos-create.php?action=edit&amp;id=<?php echo $donnees['idPromo'];?>&promo=<?php echo $donnees['nomPromo'];for ($z=0; $z < count($idsGroupes); $z++) { ?>&idGroupe[]=<?php echo $idsGroupes[$z];}?>"><img src="../../../img/icons/Edit.svg" alt=""></a>
                  <a href="promos.php?action=delete&amp;id=<?php echo $donnees['idPromo']?>"><img src="../../../img/icons/croixRouge.svg" alt=""></a>
              </td>
            </tr> 

            
        <?php
        //nettoyer tab
        $idsGroupes = array();
        $nomsGroupes = array();
      
      }
        

        $stmt->closeCursor(); // Termine le traitement de la requête
        ?>
    </table>

</body>
</html>

<?php

$_SESSION['error_message']="";
$_SESSION['done_message']="";