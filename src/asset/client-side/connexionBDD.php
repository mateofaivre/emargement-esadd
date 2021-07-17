<?php 

try {
    $options =array(PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION);
    $dbh = new PDO ('mysql:host=localhost;dbname=workshop;charset=utf8', 'root', '', $options);
}
catch (PDOException $e) {
    print "erreur !: " . $e -> getMessage(). "<br/>";
    die();
}

?>
