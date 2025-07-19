<?php include('header.php'); 

$sub = $_POST['sub'];

if(isset($sub)) {
    
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['email'];
    $confirmation_mail = $_POST['confirmation_email'];
    $tel = $_POST['telephone'];
    $date = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $cp = $_POST['code_postal'];
    $ville = $_POST['ville'];
    $pays = $_POST['pays'];
    $mdp = $_POST['pass'];
    $confirmation_pass = $_POST['confirmation_motdepasse'];

    $sql = "INSERT INTO user (id, nom, prenom, mail, num, birthday, adresse, cp, ville, pays, mdp) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt= $bdd->prepare($sql);
    $stmt->execute([$id=NULL,$nom, $prenom, $mail, $tel, $date, $adresse, $cp, $ville, $pays, $mdp]);
} else {
    echo "test2";
}

?>
<section>
    <div class="inscription">
      
        <form method="POST">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="confiramation_email">Confirmer l'email:</label>
            <input type="email" id="confirmation_email" name="confirmation_email" required>
            <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telephone" required pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide (10 chiffres)">
            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" required>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="code_postal">Code postal:</label>
            <input type="text" id="code_postal" name="code_postal" required pattern="[0-9]{5}" title="Veuillez entrer un code postal valide (5 chiffres)">

            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" required>

            <label for="pays">Pays:</label>
            <input type="text" id="pays" name="pays" required>

            <label for="motdepasse">Mot de passe:</label>
            <input type="password" id="motdepasse" name="pass" required>
            <label for="confirmation_motdepasse">Confirmer le mot de passe:</label>
            <input type="password" id="confirmation_motdepasse" name="confirmation_motdepasse" required>

            <button type="btn" name="sub">S'inscrire</button>
            
            <p>En vous inscrivant, vous acceptez nos <a href="mentionslegale.php">mentions légales</a>.</p>
            <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a>.</p>
        </form>
    </div>
    <?php include("footer.php"); ?>