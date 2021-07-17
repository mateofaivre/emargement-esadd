<?php

session_start();

$nom = $_POST['user_nom'];
$prenom = $_POST['user_prenom'];
$mail = $_POST['user_email'];
$code = $_POST['user_code'];
$signature =  htmlspecialchars($_POST["sig-dataUrl"]);
$photoName = $_FILES['user_file']['name'];
$photoTmp = $_FILES['user_file']['tmp_name'];

function checkPhoto($nom, $prenom , $mail, $code, $signature, $photoName, $photoTmp){

    include "../../client-side/connexionBDD.php";

    if (isset($_GET["id"])){
        $id = $_GET["id"];
    }

    if (isset($_POST['checkActual'])){
        $isActualUser = 1;
    }
    else {
        $isActualUser = 0;
    }
    if (isset($_POST['checkProf'])){
        $isProf = 1;
    }
    else {
        $isProf = 0;
    }

    $savePath = "../../../../images-users/";
    if ($photoName != ""){
        if($_FILES['user_file']['error'] != UPLOAD_ERR_OK) {
            $error_status = 1;
            $_SESSION['error_message'] = "Il y a eu un problème lors du chargement du fichier.";
            $_SESSION['done_message'] = "";
            if (isset($id)){
                header("Location: droits-create.php?action=edit&id=$id");
            }
            else {
                header("Location: droits-create.php");
            }
        }
        /* Ensure the file is JPG/PNG */
        elseif (($_FILES['user_file']['type'] != "image/jpg") && ($_FILES['user_file']['type'] != "image/jpeg") && ($_FILES['user_file']['type'] != "image/webp") && ($_FILES['user_file']['type'] != "image/gif") && ($_FILES['user_file']['type'] != "image/png")) { 
            $error_status = 2; 
            $_SESSION['error_message'] = "Le fichier téléchargé n'est pas correct. Formats supportés : JPG, JPEG, PNG, GIF, ou WEBP.";
            $_SESSION['done_message'] = "";
            if (isset($id)){
                header("Location: droits-create.php?action=edit&id=$id");
            }
            else {
                header("Location: droits-create.php");
            }
        }  
        else {
        /* Ensure the file is less than 10MB */
        $size = filesize($_FILES['user_file']['tmp_name']);
        if ($size > (10000 * 1024)) {
            echo $size;
            $error_status = 3;
            $_SESSION['error_message'] = "Le fichier doit peser moins de 10Mo.";
            $_SESSION['done_message'] = "";
            if (isset($id)){
                header("Location: droits-create.php?action=edit&id=$id");
            }
            else {
                header("Location: droits-create.php");
            }
        }
        else {
            //Save the image to your specified directory
            $error_status = 0;
            $error_message = '';
            move_uploaded_file($photoTmp, $savePath.DIRECTORY_SEPARATOR.$photoName);
            //now the file should be uploaded, if error status is 0, then you can safely do this:
            $Image = $photoName;
            //and put that into the database "as text"

            if (isset($id)){
                $stmt_s = $dbh->prepare("UPDATE user SET nomUser = '$nom', prenomUser = '$prenom', mailUser = '$mail', codeUser = '$code', signatureUser = '$signature', photoUser = '$Image', isActualUser = '$isActualUser', isProf = '$isProf' WHERE idUser = $id");
                $donnees_s = $stmt_s->execute();
                $_SESSION['error_message'] = "";
                $_SESSION['done_message'] = "Les modifications ont bien été effectuées.";
                header("Location: droits-create.php?action=edit&id=$id");
            }
            else {
                $stmt_s = $dbh->prepare("INSERT INTO user (nomUser, prenomUser, mailUser, codeUser, signatureUser, photoUser, isProf, isAdmin, isActualUser) VALUES ('$nom', '$prenom', '$mail', '$code', '$signature', '$Image', '$isProf', '1', '$isActualUser' )");
                $donnees_s = $stmt_s->execute();
                $_SESSION['error_message'] = "";
                $_SESSION['done_message'] = "L'utilisateur a bien été créé.";
                header("Location: droits-create.php");
            }
           
        }
        }
        
    }
    else {
        if (isset($id)){
            $stmt_s = $dbh->prepare("UPDATE user SET nomUser = '$nom', prenomUser = '$prenom', mailUser = '$mail', codeUser = '$code', signatureUser = '$signature', isActualUser = '$isActualUser', isProf = '$isProf' WHERE idUser = $id");
            $donnees_s = $stmt_s->execute();
            $_SESSION['error_message'] = "";
            $_SESSION['done_message'] = "Les modifications ont bien été effectuées.";
            header("Location: droits-create.php?action=edit&id=$id");
        }
        else {
            $stmt_s = $dbh->prepare("INSERT INTO user (nomUser, prenomUser, mailUser, codeUser, signatureUser, photoUser, isProf, isAdmin, isActualUser) VALUES ('$nom', '$prenom', '$mail', '$code', '$signature', '$Image', '$isProf', '1', '$isActualUser' )");
            $donnees_s = $stmt_s->execute();
            $_SESSION['error_message'] = "";
            $_SESSION['done_message'] = "L'utilisateur a bien été créé.";
            header("Location: droits-create.php");
        }
    }
}

checkPhoto($nom, $prenom , $mail, $code, $signature, $photoName, $photoTmp);

?>

