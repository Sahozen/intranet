<?php include('header.php'); ?>
<div class="container">
  <h1>Création d'un Nouveau Profil</h1>
  <form action="new_profile_action.php" method="post">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="firstname">Prénom :</label>
    <input type="text" id="firstname" name="firstname" required>

    <label for="lastname">Nom :</label>
    <input type="text" id="lastname" name="lastname" required>

    <label for="email">Adresse Email :</label>
    <input type="email" id="email" name="email" required placeholder="prenom.nom@alphatech.local">

    <label for="service">Service / Équipe :</label>
    <input type="text" id="service" name="service" required>

    <!-- D'autres champs peuvent être ajoutés si nécessaire -->

    <button type="submit">Créer le Profil</button>
  </form>
</div>
<?php include('footer.php'); ?>
