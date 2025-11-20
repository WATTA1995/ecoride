<?php

try {
    $bdd = new PDO
    ('mysql:host=mysql-ecorideromain.alwaysdata.net;
    dbname=ecorideromain_ecoride','441565','Azertyuiop23021995');

     $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

?> 
