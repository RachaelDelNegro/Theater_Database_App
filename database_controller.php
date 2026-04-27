<?php
    function getShows() {
        global $db;

        $stmt = $db->prepare("SELECT * FROM shows");
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

?>