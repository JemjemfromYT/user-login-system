<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect back to login page if not POST
    header("Location: index.html");
    exit();
}

// Database connection
$host = 'localhost';
$db   = 'user_login';
$user = 'root';
$pass = '';
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

// Get form input safely
$username = $_POST['username'];
$password = $_POST['password'];

// Query user from DB
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Login success
    $_SESSION['username'] = $username;
    header("Location: welcome.php");
    exit;
} else {
    // Login failed
    echo "Invalid username or password.";
}
?>
