<?php
session_start();
require_once 'bdd.php';
include('header.php');

if (!isset($_SESSION['user_id'])) {
    echo '<p class="error-message">Vous devez être connecté pour voir vos trajets.</p>';
    include('footer.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Traitement acceptation/refus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'], $_POST['trajet_id'], $_POST['action'])) {
    $reservation_id = $_POST['reservation_id'];
    $trajet_id = $_POST['trajet_id'];
    $action = $_POST['action'];

    $nouveau_statut = ($action === 'accepter') ? 'accepte' : 'refuse';

    $stmt = $bdd->prepare("UPDATE reservation SET statut = ? WHERE id = ?");
    $stmt->execute([$nouveau_statut, $reservation_id]);

    if ($action === 'accepter') {
        $stmt = $bdd->prepare("SELECT nb_places FROM reservation WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $nb_places_reservees = $stmt->fetchColumn();

        $stmt = $bdd->prepare("UPDATE covoiturage SET places = places - ? WHERE id = ?");
        $stmt->execute([$nb_places_reservees, $trajet_id]);
    }

    $message = "La réservation a été " . ($action === 'accepter' ? "acceptée" : "refusée") . " !";
}

// Récupérer les trajets
$stmt = $bdd->prepare("SELECT * FROM covoiturage WHERE user_id = ? ORDER BY date_depart DESC");
$stmt->execute([$user_id]);
$trajets = $stmt->fetchAll();
?>

<section class="mes-trajets">
    <h2>Mes trajets</h2>

    <?php if (isset($message)): ?>
        <div class="message-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!$trajets): ?>
        <p class="info">Vous n’avez encore créé aucun trajet.</p>
    <?php else: ?>
        <?php foreach ($trajets as $trajet): ?>


            <div class="trajet-card">
                <h3><?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?></h3>
                <p><strong>Date :</strong> <?= date('d/m/Y à H:i', strtotime($trajet['date_depart'])) ?></p>
                <p><strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places']) ?></p>

                <?php
                $stmt = $bdd->prepare("SELECT * FROM reservation WHERE covoiturage_id = ? ORDER BY statut, id DESC");
                $stmt->execute([$trajet['id']]);
                $reservations = $stmt->fetchAll();
                ?>

                <?php if ($reservations): ?>
                    <div class="reservations-liste">
                        <h4>Réservations :</h4>
                        <?php foreach ($reservations as $resa): ?>
                            <div class="reservation-item <?= $resa['statut'] ?>">
                                <p><strong>Nom :</strong> <?= htmlspecialchars($resa['nom']) ?></p>
                                <p><strong>Email :</strong> <?= htmlspecialchars($resa['email']) ?></p>
                                <p><strong>Places :</strong> <?= htmlspecialchars($resa['nb_places']) ?></p>
                                <p><strong>Statut :</strong> <span class="badge <?= $resa['statut'] ?>"><?= ucfirst($resa['statut']) ?></span></p>

                                <?php if ($resa['statut'] === 'en_attente'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?= $resa['id'] ?>">
                                        <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
                                        <input type="hidden" name="action" value="accepter">
                                        <button type="submit" class="btn-accept">✓ Accepter</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?= $resa['id'] ?>">
                                        <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
                                        <input type="hidden" name="action" value="refuser">
                                        <button type="submit" class="btn-refuse">✗ Refuser</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info">Aucune réservation pour ce trajet.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php include('footer.php'); ?>


