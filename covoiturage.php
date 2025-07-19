<?php include('header.php'); ?>
<section>
    <div class="covoiturage">
        <p>Accès aux covoiturages</p>
        <p>Bienvenue sur la page d'accès aux covoiturages d'EcoRide. Ici, vous pouvez trouver des trajets partagés pour réduire votre empreinte carbone et économiser sur vos déplacements.</p>

        <form action="rechercher_trajet.php" method="GET">
            <label for="depart">Départ:</label>
              <input type="text" id="adresse" name="adresse" required>

            <label for="arrivee">Arrivée:</label>
             <input type="text" id="adresse" name="adresse" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit">Rechercher</button>
        </form>


        </div>
    </div>


    <?php include("footer.php"); ?>