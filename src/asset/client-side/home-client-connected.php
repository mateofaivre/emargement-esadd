<?php
session_start();

if ( $_SESSION['isProf']==0 &&  $_SESSION['isAdmin']==0 ){
               
    
    if(isset($_SESSION['id']) && isset($_SESSION['user_name']))  {
        ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Espace de <?php echo $_SESSION['name']; ?> | Bienvenue</title>
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
                overflow:hidden;
            }

            form {
                align-items: center;
                text-align:center;
            }

            h1{
                font-size: 3em;
            }

            h4{
                color: #979797;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                margin: 0;
            }

            .infosCours {
                color: var(--colorText);
                font-weight: 600;
                font-size: 1.25rem;
                margin-bottom: 2rem;
            }

            h5{
                font-weight: 400;
                font-size: 20px;
            }

            h6{
                color: #50C285;
                font-weight: 400;
                font-size: 20px;
                margin-top: 1rem;
            }

            .circle{
                height: 50px;
                width: 50px;
                border-radius: 50%;
                border: 3px solid #50C285;
                margin-top:  3rem;
                cursor:pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                outline: none;
            }

            .circle img{
                width: 70%;
                z-index: 99;
                outline: none;
            }

            .circle:hover{
                background-color: #F9F9F9;
            }

            a{
                font-family: 'futura PT', sans-serif;
                font-weight: 300;
                font-size: 20px;
                margin-top:0;
            }

            @media all and (max-width: 600px){
                h1 {
                    font-size: 2.5rem;
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
            <h1>Merci, <?php echo $_SESSION['name'];?></h1>
            <div class="infosCours">
             <div class="infoCours"><?php echo $_SESSION['matierePresent'] ; ?> </div>
             <div class="infoCours"><?php echo   $_SESSION['dateDebut']." - ".$_SESSION['dateFin']; ?> </div>
             <div class="infoCours"><?php echo$_SESSION['groupePresent']; ?> </div>
             </div>
            <button class="button success" id="checked">Submit</button>
            
            <h6 class='noSelect'>Présence confirmée</h6>
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
        header("Location: ../../../index.php"); 
                    exit();
    }
// } else if ($_SESSION['isAdmin']==1){
//     header("Location: ../../../espace-admin.php");
//     exit();
}else{
    header("Location: fiche.php?uid=0d");
    exit();
}
    ?>