<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/config.php";

echo "<h1>Testing Database Connection...</h1>";

try {
    $stmt = $db->query("SELECT NOW() AS server_time");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<p style='color:green;'>Connected successfully!</p>";
    echo "<p>Server time: " . htmlspecialchars($result["server_time"]) . "</p>";

    $stmt2 = $db->query("SELECT COUNT(*) AS total_events FROM events");
    $events = $stmt2->fetch(PDO::FETCH_ASSOC);

    echo "<p>Total events in DB: " . htmlspecialchars($events["total_events"]) . "</p>";
} catch (PDOException $e) {
    echo "<p style='color:red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>