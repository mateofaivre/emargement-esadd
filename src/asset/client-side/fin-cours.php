<?php
session_start();

if ($_SESSION['isProf']==1 && $_SESSION['isActualUser'] == 1 ){
            
    
    if(isset($_SESSION['id']) && isset($_SESSION['user_name']))  {

        include 'connexionBDD.php';
        $idUser = $_SESSION['id'];

        $stmtCours = $dbh -> prepare("SELECT DISTINCT(cours.idCours), dateTimeDebut, dateTimeFin, nomMatiere, nomGroupe FROM coursuser, groupe, cours, groupeuser, user, matiere WHERE user.idUser = cours.idUser AND cours.idGroupe = groupe.idGroupe AND groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = '$idUser' AND cours.idMatiere = matiere.idMatiere ORDER BY `cours`.`idCours` DESC LIMIT 1");
        $donneesCours = $stmtCours-> execute();
        $donneesCours = $stmtCours -> fetch();
        $idCours = $donneesCours['idCours'];
        $dateDebut = strtotime($donneesCours['dateTimeDebut']);
        $dateDebut = date('H:i', $dateDebut);


        $dateFin = strtotime($donneesCours['dateTimeFin']);
        $dateFin = date('H:i', $dateFin);

        $_SESSION['dateDebut']= $dateDebut;
        $_SESSION['dateFin'] = $dateFin;
        $_SESSION['matierePresent'] = $donneesCours['nomMatiere'];
        $_SESSION['groupePresent'] = $donneesCours['nomGroupe'];

        ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_SESSION['name']; ?>, merci</title>
        <link rel="stylesheet" href="../../css/styles.css">
        <link rel="stylesheet" href="../../css/fin-cours.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <style>

            :root {
                --colorText: #FFA900;
                --colordark : #333333;      
                --colorGrey : #878787;
                --colorBarre : rgba(240, 240, 240, 0.7);
                --colorWhite : #FFFFFF;
                --colorDots : #DADADA;
                --colorBlack: rgba(20,20,43,1);
                --text-primary: #23232e;
                --text-secondary: #141418;
                --text-third: #929292;
                --bg-primary:  #f9f9f9;
                --bg-secondary: #f8f8f8 ;
                --jauneESADD: #FAA900;
                --transition-speed: 600ms;
                --retard: #D31818;
                --white: white;
            }

            .noSelect {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            body {
                overflow:hidden;
            }

            main{  
                flex-direction: column;
                padding: 1rem;
                overflow: hidden;   
            }

            form {
                align-items: center;
            }

            h1{
                font-size: 3em;
            }

            h4{
                color: #979797;
                text-align: center;
                font-size: 1.25rem;
            }

            h4 .infosCours {
                color: var(--colorText);
                font-weight: 600;
                margin-top: 2rem;
               
            }

            h5{
                font-weight: 400;
                font-size: 20px;
            }

            h6{
                color: #50C285;
                opacity: 0;
                font-weight: 400;
                font-size: 20px;
                position: relative;
                bottom: 80px;
            }

            .circle{
                height: 50px;
                width: 50px;
                border-radius: 50%;
                border: 3px solid #000;
                margin:  3rem;
                cursor:pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                outline: none;
            }

            .circle img{
                width: 70%;
                display: none;
                z-index: 99;
                outline: none;
            }

            .circle input {
                height: 55px;
                width: 55px;
                border-radius: 50%;
                position:absolute;
                background: transparent;
                padding:0;
                margin:0;
                border:none;
            }

            .circle:hover{
                background-color: #F9F9F9;
                cursor: pointer;
            }

            input[type=submit]:hover {
                cursor: pointer;
            }

            a{
                font-family: 'futura PT', sans-serif;
                font-weight: 300;
                font-size: 20px;
            }

            @media all and (max-width: 600px){
                h1 {
                    font-size: 2rem;
                }
                form {
                    padding: 0;
                }
            }

        </style>
    </head>
    <body>  
        <main>
            <form method="post" action="home-client-action.php" >
            <h1>Merci <?php if (isset($_SESSION['prenomProfChoisi'])) {
                echo $_SESSION['prenomProfChoisi'];
            }
            else {
                echo $_SESSION['name'];
            }?></h1>
            <h4>Votre feuille a bien été complétée et signée. <div class="infosCours">
             <div class="infoCours"><?php echo $donneesCours['nomMatiere']; ?> </div>
             <div class="infoCours"><?php echo $dateDebut." - ".$dateFin; ?> </div>
             <div class="infoCours"><?php echo $donneesCours['nomGroupe']; ?> </div>
             </div></h4>
            <button class="button success" id="checked">Submit</button>
            <h5>Vous pouvez désormais vous déconnecter</h5>
            <a href="logout-client.php">Se déconnecter</a>
            </form>
        </main>
    <script>

        var cible = document.querySelector('#checked')

        var animateButton2 = function(e) {
        console.log('tt')
        e.preventDefault;
        cible.classList.remove('animate');
        
        cible.classList.add('animate');

        cible.classList.add('animate');
        
        }

        window.addEventListener('load',  animateButton2, false)

    </script>
    </body>
    </html>

    <?php
    }else{
        // header("Location: ../../../index.php"); 
                    exit();
    }
// } else if ($_SESSION['isAdmin']==1){
//     header("Location: ../../../espace-admin.php");
//     exit();
}


// else if ($_SESSION['isProf']==1 && $_SESSION['isActualUser'] == 1 ){
//     header("Location: fiche.php?uid=0d");
//     exit();
// }

// else {
//     header("Location: 404.php");
//     exit();
// }
    ?>