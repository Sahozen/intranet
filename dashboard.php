<?php include('header.php'); ?>
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.html");
    exit();
}

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
   
<div class="container">
  <h1>Bienvenue sur la Plateforme RH Alphatech</h1>
  <p style="text-align: center;">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</p>
  <p style="text-align: center;">Veuillez choisir une des options ci-dessous :</p>
  <div style="text-align: center; margin-top: 20px;">
    <a href="new_profile.php"><button>Nouveau Profil</button></a>
    <a href="search_user.php"><button>Recherche Profil</button></a>
  </div>
</div>
<?php include('footer.php'); ?>
