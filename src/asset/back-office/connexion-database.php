
<?php
    try {
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $dbh = new PDO("mysql:host=mateofj624.mysql.db;dbname=mateofj624;charset=utf8", 'mateofj624', 'Talant10');
    } catch (PDOException $e) {
        die("Erreur !: " . $e->getMessage() . "<br/>");
    }
?>