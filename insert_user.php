<?php
// Database connection
$host = 'localhost';
$db   = 'user_login'; // Your database name
$user = 'root';       // Default XAMPP username
$pass = '';           // Default XAMPP has no password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Insert test user
$username = 'testuser';
$password = password_hash('mypassword', PASSWORD_DEFAULT); // Securely hash password

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
try {
    $stmt->execute([$username, $password]);
    echo "User inserted successfully!";
} catch (PDOException $e) {
    echo "Error inserting user: " . $e->getMessage();
}
?>
