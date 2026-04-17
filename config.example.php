<?php
// Copy this file to config.php and fill in your own credentials

$host = "mysql01.cs.virginia.edu";
$dbname = "sep8vb_b";   // our shared team database
$username = "your_mysql_username";   // UVA computing ID
$password = "your_mysql_password";   // MySQL password

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>