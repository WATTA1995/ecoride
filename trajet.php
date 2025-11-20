<?php
 include('header.php');
require_once 'bdd.php';
session_start();

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null; 
    $ville_depart = $_POST['ville_depart'];
    $ville_arrivee = $_POST['ville_arrivee'];
    $date_depart = $_POST['date_depart'];
    $places = $_POST['places'];
    $prix = $_POST['prix'];
    $vehicule = $_POST['vehicule'];
    $type_energie = $_POST['type_energie'];
    $fumeur = isset($_POST['fumeur']) ? 1 : 0;

  $success = true;

    // Requête d’insertion
    $sql = "INSERT INTO covoiturage
            (user_id, ville_depart, ville_arrivee, date_depart, places, prix, vehicule, type_energie, fumeur)
            VALUES (:user_id, :ville_depart, :ville_arrivee, :date_depart, :places, :prix, :vehicule, :type_energie, :fumeur)";

    $stmt = $bdd->prepare($sql);
    $success=$stmt->execute([
        ':user_id' => $user_id,
        ':ville_depart' => $ville_depart,
        ':ville_arrivee' => $ville_arrivee,
        ':date_depart' => $date_depart,
        ':places' => $places,
        ':prix' => $prix,
        ':vehicule' => $vehicule,
        ':type_energie' => $type_energie,
        ':fumeur' => $fumeur
    ]);

  if ($success) {
         $message =  "Trajet ajouté avec succès!";
         $message_type="success";
    } else {
         $message = " Une erreur est survenue. Veuillez réessayer.";
         $message_type="error";
     }
    }

 ?>
  
<?php if (!empty($message)) : ?>
<div class="fixed-message <?= htmlspecialchars($message_type) ?>">
    <?= htmlspecialchars($message) ?>
</div>
 <?php endif;  ?>

<section class="ajout-trajet">
    <h2>Ajouter un trajet</h2>
 
    <form method="POST" class="form-trajet">

        <label>Ville de départ :</label>
        <input type="text" name="ville_depart" class="input-field" required>

        <label>Ville d'arrivée :</label>
        <input type="text" name="ville_arrivee" class="input-field" required>

        <label>Date & heure de départ :</label>
        <input type="datetime-local" name="date_depart" class="input-field" required>

        <label>Places  :</label>
        <input type="number" name="places" min="1" class="input-field" required>

        <label>Prix (€) :</label>
        <input type="number" step="0.01" name="prix" class="input-field" required>
        <label>Marque du véhicule :</label>

        <input type="text" name="vehicule" class="input-field" required>
        <label>Type d'énergie :</label>
        <select name="type_energie" class="input-field" required>
            <option value="électrique">Électrique</option>
            <option value="essence">Essence</option>
            <option value="diesel">Diesel</option>
            <option value="hybride">Hybride</option>
        </select>
        <label><input type="checkbox" name="fumeur" class="checkbox-field"> Véhicule fumeur</label>
       <label><input type="checkbox" name="fumeur" class="checkbox-field"> animaux acceptés</label>

        <button type="submit" class="btn-submit">Ajouter le trajet</button>
      
    </form>
</section>

<?php include('footer.php'); ?>
