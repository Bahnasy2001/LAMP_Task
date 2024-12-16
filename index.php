<?php
// Database connection details
$host = 'localhost';
$dbname = 'web_db'; // Replace with your database name
$username = 'web_user'; // Replace with your MySQL username
$password = 'StrongPassword123'; // Replace with your MySQL password

try {
    // Connect to MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally create a table
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS visitors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(50) NOT NULL,
            visit_time DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $pdo->exec($createTableQuery);

    // Get visitor's IP address
    $visitorIP = $_SERVER['REMOTE_ADDR'];

    // Insert visitor's IP and current time into the table
    $insertQuery = "INSERT INTO visitors (ip_address) VALUES (:ip_address)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute(['ip_address' => $visitorIP]);

    // Fetch the current time
    $currentTime = date('Y-m-d H:i:s');

    // Display a message
    echo "<h1>Welcome to My Website</h1>";
    echo "<p>Your IP address: <strong>$visitorIP</strong></p>";
    echo "<p>Current server time: <strong>$currentTime</strong></p>";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Error connecting to the database: " . $e->getMessage();
    exit;
}
?>
