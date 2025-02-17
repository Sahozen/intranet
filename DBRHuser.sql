CREATE TABLE import_users (
    id INT PRIMARY KEY IDENTITY(1,1),  -- pour SQL Server, ou AUTO_INCREMENT pour MySQL
    GivenName NVARCHAR(50) NOT NULL,
    Surname NVARCHAR(50) NOT NULL,
    SamAccountName NVARCHAR(50) NOT NULL,
    Department NVARCHAR(50) NOT NULL,
    DisplayName NVARCHAR(100) NULL,
    UserPrincipalName NVARCHAR(100) NULL,
    EmailAddress NVARCHAR(100) NULL,
    Title NVARCHAR(100) NULL,
    TelephoneNumber NVARCHAR(50) NULL,
    StreetAddress NVARCHAR(200) NULL,
    POBox NVARCHAR(50) NULL,
    PostalCode NVARCHAR(20) NULL,
    StateOrProvince NVARCHAR(50) NULL,
    Country NVARCHAR(10) NULL,
    FullName NVARCHAR(100) NULL,
    Initials NVARCHAR(10) NULL,
    DateInserted DATETIME DEFAULT GETDATE()
);

