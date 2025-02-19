<?php
/****************************************************
 * Configuration LDAP
 ****************************************************/
$ldapServers = [
    "ldap://172.16.1.1",
    "ldap://172.16.1.2"
];
$ldapPort   = 389;  // 636 si vous utilisez LDAPS
$ldapBaseDN = "ou=Utilisateurs,dc=alphatech,dc=local";

/****************************************************
 * Variables pour messages d'erreur et de succès
 ****************************************************/
$errorMessages = [];
$successMessage = '';

/****************************************************
 * Traitement du formulaire si méthode POST
 ****************************************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Récupération des champs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 2) Vérification des champs
    if (empty($username)) {
        $errorMessages[] = "Le champ 'Nom d'utilisateur' est vide.";
    }
    if (empty($password)) {
        $errorMessages[] = "Le champ 'Mot de passe' est vide.";
    }

    // 3) Connexion au LDAP si pas d'erreur
    if (empty($errorMessages)) {
        $ldapConn = @ldap_connect($ldapServers, $ldapPort);
        if (!$ldapConn) {
            $errorMessages[] = "Impossible de se connecter au serveur LDAP (vérifiez l'adresse/port).";
        } else {
            // Paramétrage du LDAP
            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

            // Construction du DN. 
            // ATTENTION : dans un AD standard, 'uid=' n'est pas toujours l'attribut de connexion.
            // Adaptez éventuellement en sAMAccountName=, ou userPrincipalName=...
            $userDN = "uid=" . $username . "," . $ldapBaseDN;

            // Tentative de bind (authentification)
            $ldapBind = @ldap_bind($ldapConn, $userDN, $password);
            if ($ldapBind) {
                // Succès
                $successMessage = "Connexion réussie. Bienvenue, " . htmlspecialchars($username) . " !";
            } else {
                // Échec : on récupère l'erreur LDAP
                $ldapError = ldap_error($ldapConn);
                $errorMessages[] = "Échec de l'authentification LDAP : " . htmlspecialchars($ldapError);
            }

            // Fermeture de la connexion
            ldap_close($ldapConn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion RH - Alphatech</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
/****************************************************
 * Affichage des messages de succès ou d'erreur
 ****************************************************/
if (!empty($successMessage)) {
    echo "<p style='color: green; font-weight: bold;'>" . $successMessage . "</p>";
}

if (!empty($errorMessages)) {
    foreach ($errorMessages as $err) {
        echo "<p style='color: red; font-weight: bold;'>" . $err . "</p>";
    }
}
?>

<!-- Formulaire de connexion -->
<div class="login-container">
    <h2>Connexion RH</h2>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required placeholder="Votre identifiant" 
               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
        
        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>
