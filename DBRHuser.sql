CREATE TABLE import_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  GivenName VARCHAR(50) NOT NULL,
  Surname VARCHAR(50) NOT NULL,
  SamAccountName VARCHAR(50) NOT NULL,
  Department VARCHAR(50) NOT NULL,
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

$sql = "INSERT INTO profiles (username, firstname, lastname, email, service, created_at, active)
        VALUES (:username, :firstname, :lastname, :email, :service, :created_at, 1)";
