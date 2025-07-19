<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=ecoride', 'root', '');
    //echo "vous etes connecté";
} catch (PDOException $e) {
    // tenter de réessayer la connexion après un certain délai, par exemple
    //echo "erreur => " . $e->getMessage();
}

?>