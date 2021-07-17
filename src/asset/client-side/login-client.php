<?php
 session_start();  

include "db_conn-client.php";

if(isset ($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $pass = validate($_POST['password']);

 if(empty($pass)){
        header("Location: ../../../index.php?error=Pas de mot de passe");
        exit();
    }else{
        $sql="SELECT * FROM user WHERE codeUser='$pass' ";
        $result=mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);
            if(empty($row['signatureUser'])){
                $_SESSION['user_name']=$row['mailUser'];
                $_SESSION['name']=$row['prenomUser'];
                $_SESSION['id']=$row['idUser'];
                $_SESSION['idGroupe']=$row['idGroupe'];
                $_SESSION['isAdmin']=$row['isAdmin'];
                $_SESSION['isActualUser']=$row['isActualUser'];
                $_SESSION['isProf']=$row['isProf'];
                $_SESSION["signatureUser"] = $row['signatureUser'];
                header("Location: draw.php");
                exit();
            }else{
                $_SESSION['isAdmin']=$row['isAdmin'];
                $_SESSION['isActualUser']=$row['isActualUser'];
                $_SESSION['isProf']=$row['isProf'];
                $_SESSION['user_name']=$row['mailUser'];
                $_SESSION['name']=$row['prenomUser'];
                $_SESSION['id']=$row['idUser'];
                $_SESSION["signatureUser"] = $row['signatureUser'];
                if ($row['mailUser'] != "test@esadd.fr") {
                    header("Location: home-client.php");
                }
                else {
                    header("Location: fiche-admin.php");
                }
                
                exit();
            }

            
            
        }else{
            // header("Location: ../../../index.php?error=identifiant ou mdp incorrect");
            exit();
        }
    }
}else{
    // header("Location: ../../../index.php?error=identifiant ou mdp pas bon");
    exit();
}
