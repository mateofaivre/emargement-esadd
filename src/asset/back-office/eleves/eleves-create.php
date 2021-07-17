<?php   

session_start();

if ( $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 ){

       include "../../client-side/connexionBDD.php";
      
       if (isset($_GET['id'])){
        $id = $_GET['id'];
      };

      function randomPassword() {
        $alphabet = '1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
      
        echo implode($pass); //turn the array into a string
      
      }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Élèves</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="../../../css/profs-create.css">
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
        <a href="profs.php" class="nav-link">
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
        <a href="droits/droits.php" class="nav-link">
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

  <h1>Élève</h1>
    <main class="form-popup" id="form-profs">
     
    <?php if ($_SESSION['error_message'] != ''){
    ?><p class="errorMessage"> <?php  echo $_SESSION['error_message']; ?> </p><?php
    } ?>
     <?php if ($_SESSION['done_message'] != ''){
    ?><p class="doneMessage"> <?php  echo $_SESSION['done_message']; ?> </p><?php
    } ?>
   
        <form action="eleves-create-action.php<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ echo "?id=".$id; } ?>" method="post" enctype="multipart/form-data">

            <input type="text" id="user_nom" name="user_nom" placeholder="Nom" value="<?php 
            if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                $stmt_d = $dbh->prepare("SELECT idUser, nomUser, prenomUser, mailUser, codeUser, signatureUser, photoUser, isActualUser FROM user WHERE isProf = 0 AND idUser='$id'");
                $donnees_d = $stmt_d->execute();
                $donnees_d = $stmt_d->fetch();
                echo $donnees_d['nomUser'];
            }?>">

    
            <input type="text" id="user_prenom" name="user_prenom" placeholder="Prénom" value="<?php   if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){echo $donnees_d['prenomUser']; }?>" required>

       
            <input type="email" id="user_email" name="user_email" placeholder="Mail" value="<?php   if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  echo $donnees_d['mailUser']; }?>" required>

           
            <div class="containerPhoto">
                <textarea class="textareaFile"></textarea>
                <label for="user_file" class="labelFile">Choisir un fichier</label>
                <input type="file" id="user_file" name="user_file" accept="image/png, image/jpeg, image/webp, image/gif">
                <img src="../../../../images-users/<?php    if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){  echo $donnees_d['photoUser']; }?>" alt="">
            </div>


            <?php if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){ ?>
            <div class="containerSignature">
            <div id="containerDatas">
                        <textarea id="sig-dataUrl" name="sig-dataUrl" ><?php if ($donnees_d['signatureUser'] != NULL) {
                          echo $donnees_d['signatureUser'];} else {echo 'NULL';}?></textarea>
                        <h4>Signature actuelle <span class="clearSign">Effacer</span></h4>
                        <p>(L'élève doit signer lui-même.)</p>
                        <img id="sig-image" name="sig-image" src="<?php  echo $donnees_d['signatureUser']; ?>" alt="Vous devez demander à l'élève de signer lui-même !" onerror="document.querySelector('#sig-image').style.display='none'; document.querySelector('.clearSign').style.display='none'; document.querySelector('.containerSignature p').style.display='block'"/>
                    </div>
            </div>
           <?php } ?>

            <div class="pwdCheckbox">

            <div class="containerCheckbox">
            <?php if (isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){
                 if ($donnees_d['isActualUser'] == 1 ) { ?>
                <input type='checkbox' name="checkActual" class="check" id='checkActual' checked>
              <?php }
              else { ?>
                <input type='checkbox' name="checkActual" class="check" id='checkActual'>
              <?php
              } } 
              else { ?>
                <input type='checkbox' name="checkActual" class="check" id='checkActual'>
              <?php }
              ?>
              
              <label for="checkActual">Étudie actuellement</label>
            </div>

            <div class="input-group">
            <input type="password" id="txtPassword" name="user_code" placeholder="Mot de passe" value="<?php  if(isset($_GET["action"], $_GET["id"]) && $_GET["action"]=="edit" && is_numeric($_GET["id"])){echo $donnees_d['codeUser'];} else {randomPassword();} ?>" required>
            <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fas fa-eye"></i></button>
            </div>

            </div>

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
    
    <script src="../../../js/style.js"></script>
    <script src="../../../js/profs-create.js"></script>
    <script src="../../../js/main.js"></script>
</body>
</html>

<?php

if (isset($_GET['id'])){
    ?> 
    <style>
        #containerDatas{
            display:block;
        }
        #newSign{
            top: 2.5rem;
        }
        #sig-canvas{
            margin-top: 0;
        }
    </style>
    <?php
};

$_SESSION['error_message']="";
$_SESSION['done_message']="";


}

