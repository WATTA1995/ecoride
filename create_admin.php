<?php
require_once 'bdd.php'; // On inclut ta connexion à la base (celle avec root et '')

// Infos de ton compte admin
$nom = 'noc';
$prenom = 'romain';
$mail = 'admin@ecoride.com';
$motdepasse = password_hash('admin123', PASSWORD_DEFAULT); // Mot de passe sécurisé
$role = 'admin';

// Insertion dans la table user
$sql = "INSERT INTO user (role, nom, prenom, mail, mdp) VALUES (?, ?, ?, ?, ?)";
$stmt = $bdd->prepare($sql);
$stmt->execute([$role, $nom, $prenom, $mail, $motdepasse]);

echo " Compte administrateur créé avec succès !";
?>
