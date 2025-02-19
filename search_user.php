<?php include('header.php'); ?>
<div class="container">
  <h1>Recherche de Profil</h1>
  <form method="get" action="search_user.php">
    <label for="search_username">Nom d'utilisateur :</label>
    <input type="text" id="search_username" name="search_username" required>
    <button type="submit">Rechercher</button>
  </form>

  <?php
  if (isset($_GET['search_username'])) {
      $searchUsername = trim($_GET['search_username']);

      // Connexion au serveur SQL
      $server   = "172.16.1.4";
      $database = "RHDB";
      $uid      = "root";
      $pwd      = "Azerty123!";

      try {
          $dsn = "sqlsrv:Server=$server;Database=$database";
          $pdo = new PDO($dsn, $uid, $pwd);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "SELECT * FROM profiles WHERE username = :username";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([':username' => $searchUsername]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($result) {
              echo "<h2>Profil de " . htmlspecialchars($result['firstname'] . " " . $result['lastname']) . "</h2>";
              echo "<p><strong>Nom d'utilisateur :</strong> " . htmlspecialchars($result['username']) . "</p>";
              echo "<p><strong>Email :</strong> " . htmlspecialchars($result['email']) . "</p>";
              echo "<p><strong>Service :</strong> " . htmlspecialchars($result['service']) . "</p>";
              echo "<p><strong>Date de création :</strong> " . htmlspecialchars($result['created_at']) . "</p>";
              echo "<p><strong>Statut :</strong> " . ($result['active'] == 1 ? "<span style='color:green;'>Actif</span>" : "<span style='color:red;'>Inactif</span>") . "</p>";
          } else {
              echo "<p>Aucun profil trouvé pour l'utilisateur <strong>" . htmlspecialchars($searchUsername) . "</strong>.</p>";
          }
      } catch (PDOException $e) {
          echo "<p>Erreur SQL : " . $e->getMessage() . "</p>";
      }
  }
  ?>
</div>
<?php include('footer.php'); ?>
