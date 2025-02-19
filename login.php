<?php
/****************************************************
 * Configuration LDAP
 ****************************************************/
$ldapServers = [
    "ldap://172.16.1.1",
    "ldap://172.16.1.2"
]; // Adresses de vos serveurs LDAP
$ldapPort    = 389;  // Port LDAP (389 pour non sécurisé, 636 pour LDAPS)
$ldapBaseDN  = "ou=Utilisateurs,dc=alphatech,dc=local"; // Base DN pour les utilisateurs

/****************************************************
 * Tableau pour stocker les messages d'erreur
 ****************************************************/
$errorMessages = [];

/****************************************************
 * Tentative de connexion au serveur LDAP
 * (Si vous voulez tester chaque serveur successivement,
 *  il faudrait faire une boucle. Ici, on se connecte
 *  simplement à l'ensemble passé en tableau.)
 ****************************************************/
$ldapConn = @ldap_connect($ldapServers, $ldapPort);

if (!$ldapConn) {
    $errorMessages[] = "Impossible de se connecter au(x) serveur(s) LDAP. Vérifiez l'adresse et le port.";
} else {
    // Paramétrage de la version du protocole et des options
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
}

/****************************************************
 * Vérification de la méthode HTTP
 ****************************************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et validation des champs du formulaire
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Vérification si les champs sont vides
    if (empty($username)) {
        $errorMessages[] = "Le champ 'Nom d'utilisateur' est vide.";
    }
    if (empty($password)) {
        $errorMessages[] = "Le champ 'Mot de passe' est vide.";
    }

    // Si pas d'erreur jusqu'ici et connexion LDAP OK, on tente l'authentification
    if (empty($errorMessages) && $ldapConn) {
        // Construction du DN de l'utilisateur.
        // Attention : 'uid=' n'est pas toujours l'attribut par défaut en AD.
        // Adaptez éventuellement en "sAMAccountName=$username" ou "userPrincipalName" selon votre AD.
        $userDN = "uid=" . $username . "," . $ldapBaseDN;

        // Tentative de liaison (bind) avec les identifiants fournis
        $ldapBind = @ldap_bind($ldapConn, $userDN, $password);

        if ($ldapBind) {
            // Authentification réussie
            echo "<p style='color: green;'>Connexion réussie. Bienvenue, " . htmlspecialchars($username) . " !</p>";
            // Vous pouvez ici rediriger vers un tableau de bord :
            // header("Location: dashboard.php");
            // exit();
        } else {
            // Échec de l'authentification : on récupère l'erreur LDAP pour plus de détails
            $ldapError = ldap_error($ldapConn);
            $errorMessages[] = "Échec de l'authentification LDAP : " 
                               . htmlspecialchars($ldapError) 
                               . ". Vérifiez vos identifiants ou la configuration.";
        }
    }

} else {
    // Méthode HTTP différente de POST
    // Soit on redirige, soit on ajoute un message d'erreur :
    // (Ici, on ajoute un message pour le debug, mais libre à vous de rediriger.)
    $errorMessages[] = "Méthode HTTP non autorisée (attendu POST).";
}

/****************************************************
 * Affichage des erreurs s'il y en a
 ****************************************************/
if (!empty($errorMessages)) {
    foreach ($errorMessages as $msg) {
        echo "<p style='color: red;'>" . htmlspecialchars($msg) . "</p>";
    }
    // Lien de retour
    echo "<p><a href='index.html'>Retour à la page de connexion</a></p>";
}

/****************************************************
 * Fermeture de la connexion LDAP si elle existe
 ****************************************************/
if ($ldapConn) {
    ldap_close($ldapConn);
}
?>
