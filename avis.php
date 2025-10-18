<?php 
session_start();
require_once 'bdd.php';
include('header.php');

if(!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit();
}

$trajet_id = $_GET['trajet_id'] ?? null;

if (!$trajet_id) {
    echo "Trajet introuvable.";
    exit();
}

$sql = "SELECT c.*, u.prenom, u.nom
        FROM covoiturage c
        JOIN user u ON c.user_id = u.id
        WHERE c.id = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$trajet_id]);
$trajet = $stmt->fetch();

if (!$trajet) {
    echo "Trajet introuvable.";
    exit();
}

$sql = "SELECT * FROM avis WHERE trajet_id = ? AND passager_id = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$trajet_id, $_SESSION['user_id']]);
$avis_existe = $stmt->fetch();

if ($avis_existe) {
    echo "<p style='color:red;'> Vous avez déjà laissé un avis pour ce trajet.</p>";
    echo "<a href='covoiturage.php'>Retour aux trajets</a>";
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'] ?? null;
    $commentaire = $_POST['commentaire'] ?? '';
    
    if ($note) {
        $sql = "INSERT INTO avis (trajet_id, passager_id, conducteur_id, note, commentaire) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            $trajet_id,
            $_SESSION['user_id'],
            $trajet['user_id'],
            $note,
            $commentaire
        ]);
        
        $message_succes = "Merci pour votre avis !";
    } else {
        $erreur = "Veuillez sélectionner une note.";
    }
}
?>

<?php include('header.php'); ?>


            <div class="message-succes">
                <?= $message_succes ?>
                <br><br>
                <a href="covoiturage.php">Retour aux trajets</a>
            </div>

        <div class="trajet-info">
            <h3><?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?></h3>
            <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['prenom']) ?> <?= htmlspecialchars($trajet['nom']) ?></p>
            <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($trajet['date_depart'])) ?></p>
            <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> €</p>
        </div>

        <form method="POST" id="avisForm">
            <p>Comment évaluez-vous ce trajet ?</p>
            
            <div class="stars" id="stars">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>

            <div class="rating-text" id="ratingText"></div>

            <input type="hidden" name="note" id="noteInput" value="">

            <label for="commentaire"><strong>Votre commentaire (optionnel) :</strong></label>
            <textarea name="commentaire" id="commentaire" placeholder="Partagez votre expérience..."></textarea>

            <button type="submit">Envoyer mon avis</button>
        </form>

   
    </div>

    <script src="avis.js"></script>
</body>
</html>

<? include('footer.php'); ?>