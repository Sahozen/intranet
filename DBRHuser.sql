-- 1) Création de la base de données RHDB (si elle n’existe pas déjà)
CREATE DATABASE IF NOT EXISTS RHDB
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Sélection de la base de données
USE RHDB;

-- 2) Table pour les profils internes (table "profiles")
--    Cette table correspond à ce que vous insérez via le formulaire "Nouveau Profil".
--    On suppose un identifiant auto-incrémenté pour chaque profil.
CREATE TABLE IF NOT EXISTS profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,     -- ex : jdoe
    firstname VARCHAR(50) NOT NULL,    -- ex : John
    lastname VARCHAR(50) NOT NULL,     -- ex : Doe
    email VARCHAR(100) NOT NULL,       -- ex : john.doe@alphatech.local
    service VARCHAR(50) NOT NULL,      -- ex : RH, Production, etc.
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    active TINYINT(1) NOT NULL DEFAULT 1
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4;

-- 3) Table pour les données importées depuis l’AD (table "import_users")
--    On y stocke les informations extraites de l’Active Directory.
CREATE TABLE IF NOT EXISTS import_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    GivenName VARCHAR(50) NOT NULL,       -- équivalent du "Prénom" AD
    Surname VARCHAR(50) NOT NULL,         -- équivalent du "Nom" AD
    SamAccountName VARCHAR(50) NOT NULL,  -- identifiant de connexion AD
    Department VARCHAR(50) NOT NULL,      -- département/service AD
    DisplayName VARCHAR(100) NULL,
    UserPrincipalName VARCHAR(100) NULL,
    EmailAddress VARCHAR(100) NULL,
    Title VARCHAR(100) NULL,
    TelephoneNumber VARCHAR(50) NULL,
    StreetAddress VARCHAR(200) NULL,
    POBox VARCHAR(50) NULL,
    PostalCode VARCHAR(20) NULL,
    StateOrProvince VARCHAR(50) NULL,
    Country VARCHAR(10) NULL,
    FullName VARCHAR(100) NULL,
    Initials VARCHAR(10) NULL,
    DateInserted DATETIME DEFAULT CURRENT_TIMESTAMP
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4;

-- 4) (Optionnel) Création d’un index sur SamAccountName, si vous voulez accélérer les recherches
CREATE INDEX idx_samaccountname ON import_users (SamAccountName);

-- 5) (Optionnel) Création d’un index sur username dans la table profiles
CREATE INDEX idx_username ON profiles (username);

-- Fin du script
