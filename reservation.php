
<?php
session_start();
require_once 'bdd.php';
include('header.php');

$id_utilisateur = $_SESSION['user_id'] ?? null;
if (!$id_utilisateur) {
    echo "<p style='color:red;'> Vous devez être connecté pour faire une réservation.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $covoiturage_id = $_POST['covoiturage_id'] ?? null;
    $nb_places = $_POST['nb_places'] ?? 0;
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $date_reservation = date('Y-m-d H:i:s');
    $statut = 'en_attente';
    
    if (!$covoiturage_id) {
        echo "<p style='color:red;'> Aucun ID de trajet fourni.</p>";
        exit;
    }
    
    if ($nb_places <= 0) {
        echo "<p style='color:red;'> Le nombre de places doit être supérieur à zéro.</p>";
        exit;
    }

    // Vérifier qu'il y a assez de places disponibles
    $stmt = $bdd->prepare("SELECT places_disponibles FROM covoiturage WHERE id = ?");
    $stmt->execute([$covoiturage_id]);
    $trajet = $stmt->fetch();
    
    if ($trajet['places_disponibles'] < $nb_places) {
        echo "<p style='color:red;'> Pas assez de places disponibles.</p>";
        exit;
    }

    // Insérer la réservation
    try {
        $stmt = $bdd->prepare("INSERT INTO reservation (covoiturage_id, utilisateur_id, nom, email, nb_places, date_reservation, statut) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $covoiturage_id,
            $id_utilisateur,
            $nom,
            $email,
            $nb_places,
            $date_reservation,
            $statut
        ]);

       echo "<section style='text-align:center; padding:50px;'>";
       echo "<p style='color:green; font-size:20px; font-weight:bold;'> Demande de réservation envoyée !</p>";
        echo "<p style='color:#666;'>Le conducteur doit valider votre demande.</p>";
        echo "<p style='color:#666;'>Vous serez notifié une fois la réservation validée.</p>";
        echo "<br><a href='covoiturage.php' style='background:#4CAF50; color:white; padding:15px 30px; text-decoration:none; border-radius:5px;'>Retour aux trajets</a>";
        echo "</section>";
        
    } catch (PDOException $e) {
        echo "<p style='color:red;'> Erreur lors de la réservation : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red;'> Méthode non autorisée.</p>";
}

include('footer.php');
?>