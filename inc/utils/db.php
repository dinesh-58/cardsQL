<?php
function connect_db()
{
    try {
        $pdo = new PDO("sqlite:cardsql.db");
        // Enable foreign key constraints for this connection
        // this needs to be set for every connection so always use this function to connect to db
        $pdo->exec("PRAGMA foreign_keys = ON;");
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
