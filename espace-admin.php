<?php 



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESADD | Espace Admin</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <main>
        <div class="container">
          <form action="src/asset/login.php" method="post">
            <?php if (isset($_GET['error'])){?>
              <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <h2>Bienvenue</h2>
            <div class="input-group">
              <!-- <label for="txtUserName">Nom d'utilisateur</label> -->
              <input type="text" class="form-control" name="txtUserName" id="txtUserName"/>
            </div>
            <div class="input-group">
              <!-- <label for="txtPassword">Mot de passe</label> -->
              <input type="password" id="txtPassword" class="form-control" name="txtPassword" />
              <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
            </div>
            <button class="btn" type='submit'>Se connecter</button> 
            <a href="index.php">Accédez à l'espace principal <i class="fal fa-arrow-right"></i></a>           
          </form>
        </div>
      </main>
      <script src="src/js/style.js"></script>
</body>
</html>

<?php 
