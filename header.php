<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Plateforme RH - Alphatech</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="dashboard.php">Accueil</a></li>
        <li><a href="new_profile.php">Nouveau Profil</a></li>
        <li><a href="search_user.php">Recherche Profil</a></li>
        <li style="float: right;"><a href="logout.php" class="logout-button">Déconnexion</a></li>
      </ul>
    </nav>
  </header>
  <!-- Début du contenu de la page -->
