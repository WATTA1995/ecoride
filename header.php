<?php require_once('bdd.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRide</title>
    <meta name="description" content="">
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

                <a href="contact.php">
                    <div class="logo">
                        <span class="fa fa-envelope"></span>
                        <span>Contact</span>
                    </div>
                </a>
                <a href="#">
                    <form method="POST" class="logo">
                        
                        <input name="trajet" type="text" id="choixTrajet" placeholder="rechercher" />

                        <!--<select id="trajet">
                    <option value="paris-lyon">paris-lyon</option>
                    <option value="marseille-nice">marseille-nice</option>
                    <option value="bordeaux-toulouse">bordeaux-toulouse</option>
                    <option value="lille-roubaix">lille-roubaix</option>
                    <option value="nantes-rennes">nantes-rennes</option>
                    <option value="strasbourg-mulhouse">strasbourg-mulhouse</option>
                    <option value="montpellier-perpignan">montpellier-perpignan</option>
                </select>-->
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </a>
                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                    <i class="fa fa-bars"></i></a>
            </div>
        </nav>
    </header>