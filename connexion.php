<?php include('header.php');


session_start();
require_once 'bdd.php'; // fichier avec la connexion PDO
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $motdepasse = $_POST['motdepasse'] ?? '';

    // Requête pour récupérer l'utilisateur
    $stmt = $bdd->prepare("SELECT * FROM user WHERE mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['mdp'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['mail'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role']; 

        if ($user['role'] === 'conducteur') {
            header('Location: trajet.php'); // Rediriger vers la page conducteur
            exit;
        } else {
            header('Location: covoiturage.php'); // Rediriger vers la page passager
            exit;
        }
    } else {
        header('location: connexion.php');
        $_SESSION['error'] = "Identifiants incorrects.";
}
 }
?>


<section>
    <form class="connexion" method="post" action="connexion.php">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="Entrez votre email">
        <label for="motdepasse">Mot de passe</label>
        <input type="password" id="motdepasse" name="motdepasse" required placeholder="Entrez votre mot de passe">
        <button type="submit">Se connecter</button>
        <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
    </form>
</section> 
<?php include("footer.php"); ?>