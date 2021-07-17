<?php
session_start();

$identifiant = $_SESSION['id'];

echo "$identifiant";

if (isset( $_POST["sig-dataUrl"])) {

    $imgUrl  = htmlspecialchars($_POST["sig-dataUrl"]);

    include 'connexionBDD.php';

    $stmt = $dbh->prepare("UPDATE user
    SET signatureUser = '$imgUrl'
    WHERE idUser = '$identifiant' " );

    $stmt->execute();

    header ("Location: home-client.php");

}
else {
    echo "pas de signature, veuillez réesayer";
}

?>