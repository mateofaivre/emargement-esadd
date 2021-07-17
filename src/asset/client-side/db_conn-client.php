<?php

$sname="localhost";
$unmae="root";
$password="";

$db_name="workshop";
$conn=mysqli_connect($sname,$unmae,$password,$db_name);
mysqli_set_charset($conn, 'utf8');
if(!$conn){
    echo"Connexion a échouée";
}