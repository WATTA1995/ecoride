<?php include('header.php'); ?>
<section>
    <form class="connexion">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="Entrez votre email">
        <label for="motdepasse">Mot de passe</label>
        <input type="password" id="motdepasse" name="motdepasse" required placeholder="Entrez votre mot de passe">
        <button type="submit">Se connecter</button>
        <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>   
    </form>
</section>
<?php include("footer.php"); ?>