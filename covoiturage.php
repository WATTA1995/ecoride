<?php
session_start();

/*if (!isset($_SESSION['user_role'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SESSION['user_role'] !== 'passager') {
    echo "Accès réservé aux passagers.";
    exit();
}*/


require_once 'bdd.php';
include('header.php');
 
    ?>

<section class="covoiturage">
   
    <h2>Rechercher un trajet</h2>
    <form method ="GET"> 
    

        <label>Départ :</label>
        <input type="text" name="depart" required>

        <label>Arrivée :</label>
        <input type="text" name="arrivee" required>

        <label>Date :</label>
        <input type="date" name="date" required>

        <button type="submit">Rechercher</button>
    </form>

<?php
 // Si on a cliqué sur "Rechercher"
    if (isset($_GET['depart'], $_GET['arrivee'], $_GET['date'])) {
        $depart = $_GET['depart'];
        $arrivee = $_GET['arrivee'];
        $date = $_GET['date'];

        $sql = "SELECT * FROM covoiturage 
                WHERE ville_depart = :depart 
                AND ville_arrivee = :arrivee 
                AND DATE(date_depart) = :date";

        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            'depart' => $depart,
            'arrivee' => $arrivee,
            'date' => $date
        ]);

        $trajets = $stmt->fetchAll();

       
        if ($trajets) {
            foreach ($trajets as $t) {
               echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0'>";
                echo "<a href='detail.php?id={$t['id']}'><strong>{$t['ville_depart']} → {$t['ville_arrivee']}</strong><br>";
                echo "Départ : {$t['date_depart']}<br>";
                echo "Places : {$t['places_disponibles']}<br>";
                echo "Prix : {$t['prix']} €<br>";
                echo "Vehicule : {$t['vehicule']} ({$t['type_energie']})<br>";
                echo "Fumeur : " . ($t['fumeur'] ? 'Oui' : 'Non') . "<br>";
                echo "</div>";
            }
        } else {
            echo "<p style='color:white;'> Aucun trajet trouvé.</p>";
        }
    }
    ?>

</section>

<?php include('footer.php'); ?>