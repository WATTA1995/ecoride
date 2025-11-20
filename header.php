<?php require_once('bdd.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRide</title> 
    <meta name="description" content="Recherche un covoiturage près de chez vous avec Ecoride, voyagez vert en respectant la planète. "> 
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="styles/style.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header>
        <nav>
            <div class="topnav" id="myTopnav">

                <a href="index.php" class="active">
                    <div class="logo">
                        <span class="fa fa-home"></span>
                        <span>Accueil</span>
                    </div>
                </a>
                <a href="covoiturage.php">
                    <div class="logo">
                        <span>Accès aux covoiturage</span>
                    </div>
                    <a href=trajet.php>
                        <div class="logo">
                            <span>Trajet</span>
                        </div>
                    </a>
                    <a href="inscription.php">
                        <div class="logo">
                            <span>inscription</span>
                        </div>
                    </a>
                    <a href="connexion.php">
                        <div class="logo">
                            <span>connexion</span>
                        </div>
                    </a>
                    <a href="mes_trajet.php"> Mes trajets</a>
                    
                    <a href="contact.php">
                        <div class="logo">
                            <span class="fa fa-envelope"></span>
                            <span>Contact</span>
                        </div>
                    </a>
                    <a href="deconnexion.php" class="logout-link">
                    <div class="logo">
                        <span class="fa fa-sign-out"></span>
                        <span>Déconnexion</span>
                    </div>
                </a>
   
  <div class="welcome-bubble" id="welcomeBubble"> 
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom'] ?? 'Invité'); ?>!</p>
    <span class="close-btn" onclick="closeBubble()">&times;</span>
  </div>

  <script src="scripts/scripts.js"></script>

                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                    <i class="fa fa-bars"></i></a>
            </div>
        </nav>
    </header>