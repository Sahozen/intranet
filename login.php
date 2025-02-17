<?php
// Configuration LDAP

$ldapServers = [
    "ldap://172.16.1.1",
    "ldap://172.16.1.2"  
]; // Adresse de votre serveur LDAP

$ldapPort    = 389; // Port LDAP (389 pour non sécurisé, 636 pour LDAPS)
$ldapBaseDN  = "ou=RH,dc=alphatech,dc=local"; // Base DN pour les utilisateurs RH

// Connexion au serveur LDAP
$ldapConn = ldap_connect($ldapServer, $ldapPort) or die("Impossible de se connecter au serveur LDAP.");

// Paramétrage de la version du protocole et des options
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des informations de connexion
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Construction du DN de l'utilisateur.
    // Selon votre architecture LDAP, le DN peut différer.
    // Ici, nous supposons que l'utilisateur se trouve dans l'unité "RH" avec pour attribut uid.
    $userDN = "uid=" . $username . "," . $ldapBaseDN;
    
    // Tentative de liaison (bind) avec les identifiants fournis
    $ldapBind = @ldap_bind($ldapConn, $userDN, $password);
    
    if ($ldapBind) {
        // Authentification réussie
        echo "<p style='color: green;'>Connexion réussie. Bienvenue, " . htmlspecialchars($username) . " !</p>";
        // Vous pouvez ici rediriger vers un tableau de bord RH par exemple :
        // header("Location: dashboard.php");
        // exit();
    } else {
        // Échec de l'authentification
        echo "<p style='color: red;'>Échec de l'authentification. Veuillez vérifier vos identifiants.</p>";
        echo "<p><a href='index.html'>Retour à la page de connexion</a></p>";
    }
} else {
    // Si le formulaire n'est pas soumis, redirigez vers la page de connexion
    header("Location: index.html");
    exit();
}

// Fermeture de la connexion LDAP
ldap_close($ldapConn);
?>
