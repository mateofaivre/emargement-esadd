<?php
session_start();

if(!isset($_SESSION['id']) && !isset($_SESSION['user_name'])){

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESADD | Login</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <main>
        <div class="container">
          <form action="src/asset/client-side/login-client.php" method="post">
          <?php if (isset($_GET['error'])){?>
            <p class="error"><?php echo $_GET['error']; ?></p>
          <?php } ?>

            <h2>Bienvenue</h2>
            <div class="input-group">
              <!-- <label for="txtPassword">Code confidentiel</label> -->
              <input type="password" id="txtPassword" class="form-control" name="password" />
              <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fas fa-eye"></i></button>
            </div>
            <button class="btn" type="submit">Se connecter</button> 
            <a href="espace-admin.php">Accédez à l'espace admin<i class="fal fa-arrow-right"></i></a>           
          </form>
        </div>
      </main>
      <script src="src/js/style.js"></script>
</body>
</html>
<?php
}
else {
  header("Location: src/asset/client-side/home-client.php");
}