<?php 
session_start();
include('header.php');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=EcoRide', 'root', '');
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}

// Récupérer l'ID du trajet
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    echo "<p style='color:red;'> ID de trajet invalide.</p>";
    exit;
}

// Récupérer les détails du trajet
$stmt = $pdo->prepare('SELECT * FROM covoiturage WHERE id = :id');
$stmt->execute(['id' => $id]);
$trajet = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les avis pour ce trajet
$stmt_avis = $pdo->prepare('SELECT a.*, u.prenom, u.nom 
                            FROM avis a 
                            JOIN user u ON a.passager_id = u.id 
                            WHERE a.trajet_id = :id 
                            ORDER BY a.date_creation DESC');
$stmt_avis->execute(['id' => $id]);
$avis_liste = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);

// Calculer la note moyenne
$stmt_moyenne = $pdo->prepare('SELECT AVG(note) as moyenne, COUNT(*) as total 
                                FROM avis 
                                WHERE trajet_id = :id');
$stmt_moyenne->execute(['id' => $id]);
$stats = $stmt_moyenne->fetch(PDO::FETCH_ASSOC);
$moyenne = $stats['moyenne'] ? round($stats['moyenne'], 1) : 0;
$total_avis = $stats['total'];
?>

<section class="reservation"> 
    <div class="trajet-details">
        <h2>Détails du Trajet</h2>
        <div class="trajet-info">
            <p class="trajet-route"><strong><?php echo $trajet['ville_depart']; ?> → <?php echo $trajet['ville_arrivee']; ?></strong></p>
            <p class="trajet-item">Départ : <?php echo $trajet['date_depart']; ?></p>
            <p class="trajet-item">Places : <?php echo $trajet['places_disponibles']; ?></p>
            <p class="trajet-item">Prix : <?php echo $trajet['prix']; ?> €</p>
            <p class="trajet-item">Véhicule : <?php echo $trajet['vehicule']; ?> (<?php echo $trajet['type_energie']; ?>)</p>
            <p class="trajet-item">Fumeur : <?php echo ($trajet['fumeur'] ? 'Oui' : 'Non'); ?></p>
        </div>

        <!-- SECTION AVIS -->
        <div class="avis-section">
            <h2>Avis des passagers</h2>
            
            <?php if ($total_avis > 0): ?>
                <div class="note-moyenne">
                    <p><?php echo $moyenne; ?>/5</p>
                    <p>Basé sur <?php echo $total_avis; ?> avis</p>
                </div>

                <div class="liste-avis">
                    <?php foreach ($avis_liste as $avis): ?>
                        <div class="avis-item">
                            <div class="avis-header">
                                <strong><?php echo htmlspecialchars($avis['prenom']); ?> <?php echo htmlspecialchars(substr($avis['nom'], 0, 1)); ?>.</strong>
                                <span class="avis-note">
                                    <?php echo str_repeat('⭐', $avis['note']); ?> (<?php echo $avis['note']; ?>/5)
                                </span>
                            </div>
                            
                            <?php if (!empty($avis['commentaire'])): ?>
                                <p class="avis-commentaire"><?php echo nl2br(htmlspecialchars($avis['commentaire'])); ?></p>
                            <?php endif; ?>
                            
                            <p class="avis-date">
                                <small>Le <?php echo date('d/m/Y à H:i', strtotime($avis['date_creation'])); ?></small>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="aucun-avis">Aucun avis pour ce trajet. Soyez le premier !</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="btn-container">
                    <a href="avis.php?trajet_id=<?php echo $id; ?>" class="btn-avis"> Laisser un avis</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- FORMULAIRE DE RÉSERVATION -->
        <h2>Réserver ce trajet</h2>
        <form action="reservation.php" method="POST">
            <input type="hidden" name="covoiturage_id" value="<?php echo $id; ?>">
            
            <label for="nom">Nom:</label>
            <input type="text" name="nom" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="nb_places">Nombre de places:</label>
            <input type="number" name="nb_places" min="1" max="<?php echo $trajet['places_disponibles']; ?>" required>
            
            <input type="submit" value="Réserver">
        </form>
    </div>
</section>

<?php include('footer.php'); ?>