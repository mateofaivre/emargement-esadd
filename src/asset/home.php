<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name']) &&  $_SESSION['isAdmin']==1 && $_SESSION['isActualUser'] == 1 )  {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de <?php echo $_SESSION['name'];?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        main{  
            flex-direction: column;
        }

        h1{
            font-size: 3em;
        }

    </style>
</head>
<body>
    
    <main>
        <h1>Hello,<?php echo $_SESSION['name'];?></h1>
        <a href="logout.php">Se déconnecter</a>
    </main>
        
</body>
</html>

<?php
}else{
    header("Location: ../../espace-admin.php");
                exit();
}
?>