<?php
session_start();
include "db_conn.php";



if(isset($_POST['txtUserName']) && isset ($_POST['txtPassword'])){
    echo 'test';
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['txtUserName']);
    $pass = validate($_POST['txtPassword']);

    if(empty($uname)){
        header("Location: ../../index.php?error=Pas d'identifiant");
        exit();
    }else if(empty($pass)){
        header("Location: ../../index.php?error=Pas de mot de passe");
        exit();
    }else{
        $sql="SELECT * FROM user WHERE mailUser='$uname' AND codeUser='$pass' ";
        $result=mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);
            if($row['mailUser']===$uname && $row['codeUser']===$pass){
                $_SESSION['user_name']=$row['mailUser'];
                $_SESSION['name']=$row['prenomUser'];
                $_SESSION['id']=$row['idUser']; 
                $_SESSION['isProf']=$row['isProf'];
                $_SESSION['isAdmin']=$row['isAdmin'];
                $_SESSION['isActualUser']=$row['isActualUser'];
                $_SESSION['photoUser']=$row['photoUser'];
                header("Location: back-office/home.php"); 
                exit();
            }else{
                header("Location: ../../espace-admin.php?error=identifiant ou mdp incorrect");
                exit();
            }
        }else{
            echo 'nn';
            header("Location: ../../espace-admin.php?error=identifiant ou mdp incorrect");
            exit();
        }
    }
}else{
    header("Location: ../../espace-admin.php");
    exit();
}
