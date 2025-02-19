<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.html");
    exit();
}

// Récupération et assainissement des données du formulaire
$username  = trim($_POST['username']);
$firstname = trim($_POST['firstname']);
$lastname  = trim($_POST['lastname']);
$email     = trim($_POST['email']);
$service   = trim($_POST['service']);

// Date de création
$created_at = date("Y-m-d H:i:s");

// Connexion au serveur SQL (SQL Server)
$server   = "172.16.1.4";
$database = "RHDB"; // Nom de la base de données
$uid      = "root";
$pwd      = "Azerty123!";

try {
    // DSN pour SQL Server avec PDO
    $dsn = "sqlsrv:Server=$server;Database=$database";
    $pdo = new PDO($dsn, $uid, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertion dans la table profiles (active = 1 par défaut)
    $sql = "INSERT INTO profiles (username, firstname, lastname, email, service, created_at, active)
            VALUES (:username, :firstname, :lastname, :email, :service, :created_at, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username'  => $username,
        ':firstname' => $firstname,
        ':lastname'  => $lastname,
        ':email'     => $email,
        ':service'   => $service,
        ':created_at'=> $created_at
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion ou d'insertion SQL : " . $e->getMessage());
}

// Génération ou mise à jour du fichier CSV
$csvDirectory = "csv_exports";
if (!file_exists($csvDirectory)) {
    mkdir($csvDirectory, 0777, true);
}

// Nom du fichier CSV basé sur la date et l'heure actuelle
$fileName = "Extraction new user - " . date("d - m - Y - H - i") . ".csv";
$filePath = $csvDirectory . "/" . $fileName;

// Si le fichier n'existe pas, on le crée et on écrit l'en-tête
if (!file_exists($filePath)) {
    $file = fopen($filePath, "w");
    fputcsv($file, ["Username", "FirstName", "LastName", "Email", "Service", "Created_at"]);
} else {
    $file = fopen($filePath, "a");
}

// Écriture des données dans le CSV
fputcsv($file, [$username, $firstname, $lastname, $email, $service, $created_at]);
fclose($file);
?>

<?php include('header.php'); ?>
<div class="container">
  <h1>Profil Créé avec Succès</h1>
  <p>Le profil de <strong><?php echo htmlspecialchars($firstname . " " . $lastname); ?></strong> a été créé.</p>
  <p>Les informations ont été enregistrées dans la base de données et dans le fichier CSV : <strong><?php echo htmlspecialchars($fileName); ?></strong></p>
  <p><a href="dashboard.php"><button>Retour au Tableau de Bord</button></a></p>
</div>
<?php include('footer.php'); ?>
