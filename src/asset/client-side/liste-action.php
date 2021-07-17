<?php 
session_start();


$uid = $_GET["uid"];
$absentTab = ($_SESSION["idAbsent"]);
$presentTab = ($_SESSION["idPresent"]);
$idCours = $_SESSION["idCours"];
$heureArrivee =  $_SESSION["heureArrivee"];
$heureDebut = $_SESSION['heureDebut'];

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    include 'connexionBDD.php';

    if (isset($_GET['nom']) || isset($_GET['prenom'])){
   
    $nomEleve = $_GET['nom']; $prenomEleve = $_GET['prenom'];
    $prenomEleve =  str_replace('%20', ' ', $prenomEleve);
    $prenomEleve = str_replace(' ', '', $prenomEleve);


    $stmtEleve = $dbh -> prepare("SELECT idUser FROM user WHERE nomUser='$nomEleve' AND prenomUser='$prenomEleve'");
    $donneesEleve = $stmtEleve -> execute();
    $donneesEleve = $stmtEleve -> fetch();
    $idUser = $donneesEleve['idUser'];

    }

    if (isset($_POST["validerRetard"]) || isset($_POST["validerRetardPrésence"])){      

        if(isset($_POST['inputMinRetard'])){

       
        if (isset($_POST['inputHeureRetard'])){
           
            $timeToAdd = $_POST['inputHeureRetard'].' hour '.$_POST['inputMinRetard'].' min';
           
        }
        else {
            $timeToAdd = $_POST['inputMinRetard'].' min';
        }

        $heureRetard = strtotime('+'.$timeToAdd, $heureDebut);  
        echo $heureRetard = date('Y-m-d H:i:s', $heureRetard);

        if(isset($_POST['validerRetard'])) {
            echo 'c';
            echo $idUser;
            echo $heureRetard;
            $stmtRetard = $dbh -> prepare("INSERT INTO coursuser VALUES ('$idCours','$idUser','$heureRetard', '0') ");
        }
        if(isset($_POST['validerRetardPrésence'])){
            echo 'b';
            $stmtRetard = $dbh -> prepare("UPDATE coursuser SET heureArrivee = '$heureRetard' WHERE idCours='$idCours'AND idUser='$idUser' ");
        }
        $donneesRetard = $stmtRetard->execute();

        }

        if (isset($_POST['inputMinRetardAlready'])){
            if (isset($_POST['inputHeureRetard'])){
                $timeToAdd = $_POST['inputHeureRetard'].' hour '.$_POST['inputMinRetardAlready'].' min';
            }
            else {
                $timeToAdd = $_POST['inputMinRetardAlready'].' min';    
            }
            $heureRetard = strtotime('+'.$timeToAdd, $heureDebut);  
            $heureRetard = date('Y-m-d H:i:s', $heureRetard);

            $stmtRetard = $dbh -> prepare("UPDATE coursuser SET heureArrivee = '$heureRetard' WHERE idUser = '$idUser' ");
            $donneesRetard = $stmtRetard->execute();
        }

        header("Location: liste.php?uid=$uid");

    }

    if (isset($_POST['alheure'])){
        $heureDebut = date('Y-m-d H:i:s', $heureDebut);
        $stmtAlheure = $dbh -> prepare("UPDATE coursuser SET heureArrivee = '$heureDebut' WHERE idUser = '$idUser' ");
        $donneesAlheure = $stmtAlheure->execute();
    }

    

    if (isset($_POST["validerPrésence"])){
        echo 'present';
        echo $idUser." ";
        echo $idCours, $heureArrivee;
        $stmtPresent = $dbh -> prepare("INSERT INTO coursuser (idUser, idCours, heureArrivee) VALUES ('$idUser', '$idCours', '$heureArrivee') ");
        $donneesPresent = $stmtPresent->execute();
    }

    if (isset($_POST["validerAbsence"])){
        $stmtAbsent = $dbh -> prepare("DELETE FROM coursuser WHERE idUser = '$idUser' AND idCours = '$idCours' ");
        $donneesAbsent = $stmtAbsent->execute();
    }

    if (isset($_POST["btSigner"])){

        echo 'btSigner';
    
    
        $stmtEnd = $dbh -> prepare("UPDATE cours SET isEnded = '1' WHERE idCours = '$idCours' ");
        $donneesEnd = $stmtEnd->execute();
        
            header ("Location: fin-cours.php?uid=$uid");
    }

    else {
        header("Location: liste.php?uid=$uid");
    }

}
?>
