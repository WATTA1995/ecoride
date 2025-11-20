<?php
session_start();
require_once 'bdd.php';
include('header.php');
?>

<section class="covoiturage">
    <h2>Rechercher un trajet</h2>
    <form method="GET"> 
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
    if (isset($_GET['depart'], $_GET['arrivee'], $_GET['date'])):
        $depart = $_GET['depart'];
        $arrivee = $_GET['arrivee'];
        $date = $_GET['date'];

        $sql = "SELECT DISTINCT * FROM covoiturage 
                WHERE ville_depart = :depart 
                AND ville_arrivee = :arrivee 
                AND DATE(date_depart) = :date";

        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            'depart' => $depart,
            'arrivee' => $arrivee,
            'date' => $date
        ]);

        $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $trajets = array_unique($trajets, SORT_REGULAR);
    ?>

        <?php if ($trajets): ?>
            <?php foreach ($trajets as $t): ?>
                <div style="border:1px solid #6b2f2fff; padding:10px; margin:10px 0">
                    <a href="detail.php?id=<?= $t['id'] ?>">
                        <strong><?= htmlspecialchars($t['ville_depart']) ?> → <?= htmlspecialchars($t['ville_arrivee']) ?></strong>
                    </a><br>
                    Départ : <?= htmlspecialchars($t['date_depart']) ?><br>
                    Places : <?= htmlspecialchars($t['places']) ?><br>
                    Prix : <?= htmlspecialchars($t['prix']) ?> €<br>
                    Véhicule : <?= htmlspecialchars($t['vehicule']) ?> (<?= htmlspecialchars($t['type_energie']) ?>)<br>
                    Fumeur : <?= $t['fumeur'] ? 'Oui' : 'Non' ?><br>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:white;">Aucun trajet trouvé.</p>
        <?php endif; ?>

    <?php endif; ?>
</section>

<?php include('footer.php'); ?>
