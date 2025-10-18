<?php
session_start();
require_once 'bdd.php';
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$trajet_id = $_GET['trajet_id'] ?? 0;

// Vérifier que le trajet appartient au conducteur
$sql = "SELECT * FROM covoiturage WHERE id = ? AND user_id = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$trajet_id, $_SESSION['user_id']]);
$trajet = $stmt->fetch();

if (!$trajet) {
    echo "Accès non autorisé.";
    exit();
}

// Traitement acceptation/refus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];
    
    $nouveau_statut = ($action === 'accepter') ? 'accepte' : 'refuse';
    
    // Mettre à jour le statut
    $sql = "UPDATE reservation SET statut = ? WHERE id = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$nouveau_statut, $reservation_id]);
    
    // Si accepté, diminuer les places
    if ($action === 'accepter') {
        $sql = "SELECT nb_places FROM reservation WHERE id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$reservation_id]);
        $nb_places_reservees = $stmt->fetch()['nb_places'];
        
        $sql = "UPDATE covoiturage 
                SET places_disponibles = places_disponibles - ? 
                WHERE id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$nb_places_reservees, $trajet_id]);
    }
    
    $message = "La réservation a été " . ($action === 'accepter' ? "acceptée" : "refusée") . " !";
}

// Récupérer les réservations
$sql = "SELECT r.* 
        FROM reservation r 
        WHERE r.covoiturage_id = ?
        ORDER BY r.statut, r.id DESC";
$stmt = $bdd->prepare($sql);
$stmt->execute([$trajet_id]);
$reservations = $stmt->fetchAll();
?>

<section class="gerer-reservations">
    <h2>Gérer les réservations</h2>
    
    <div class="trajet-info">
        <h3><?php echo htmlspecialchars($trajet['ville_depart']); ?> → <?php echo htmlspecialchars($trajet['ville_arrivee']); ?></h3>
        <p><strong>Date :</strong> <?php echo date('d/m/Y à H:i', strtotime($trajet['date_depart'])); ?></p>
        <p><strong>Places disponibles :</strong> <?php echo $trajet['places_disponibles']; ?></p>
    </div>

    <?php if (isset($message)): ?>
        <div class="message-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($reservations): ?>
        <?php 
        $demandes_attente = array_filter($reservations, function($r) { return $r['statut'] === 'en_attente'; });
        $demandes_acceptees = array_filter($reservations, function($r) { return $r['statut'] === 'accepte'; });
        $demandes_refusees = array_filter($reservations, function($r) { return $r['statut'] === 'refuse'; });
        ?>

        <?php if ($demandes_attente): ?>
            <h3>Demandes en attente</h3>
            <?php foreach ($demandes_attente as $resa): ?>
                <div class="reservation-card attente">
                    <div class="reservation-info">
                        <p><strong>Passager :</strong> <?php echo htmlspecialchars($resa['nom']); ?></p>
                        <p><strong>Email :</strong> <?php echo htmlspecialchars($resa['email']); ?></p>
                        <p><strong>Places demandées :</strong> <?php echo $resa['nb_places']; ?></p>
                    </div>
                    
                    <div class="reservation-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $resa['id']; ?>">
                            <input type="hidden" name="action" value="accepter">
                            <button type="submit" class="btn-accepter">✓ Accepter</button>
                        </form>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $resa['id']; ?>">
                            <input type="hidden" name="action" value="refuser">
                            <button type="submit" class="btn-refuser">✗ Refuser</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($demandes_acceptees): ?>
            <h3>Réservations acceptées</h3>
            <?php foreach ($demandes_acceptees as $resa): ?>
                <div class="reservation-card accepte">
                    <p><strong>Passager :</strong> <?php echo htmlspecialchars($resa['nom']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($resa['email']); ?></p>
                    <p><strong>Places :</strong> <?php echo $resa['nb_places']; ?></p>
                    <span class="badge-accepte">✓ Accepté</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($demandes_refusees): ?>
            <h3>Réservations refusées</h3>
            <?php foreach ($demandes_refusees as $resa): ?>
                <div class="reservation-card refuse">
                    <p><strong>Passager :</strong> <?php echo htmlspecialchars($resa['nom']); ?></p>
                    <p><strong>Places :</strong> <?php echo $resa['nb_places']; ?></p>
                    <span class="badge-refuse">✗ Refusé</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php else: ?>
        <p>Aucune réservation pour ce trajet.</p>
    <?php endif; ?>

    <a href="mes_trajets.php" class="btn-retour">← Retour à mes trajets</a>
</section>

<?php include('footer.php'); ?>