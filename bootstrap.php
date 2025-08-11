<?php
// constant values to use across site
define("BASE_DIR", __DIR__);
define("BASE_URL", "http://localhost:8000");

function connect_db()
{
    try {
        $pdo = new PDO("sqlite:" . BASE_DIR . "/cardsql.db");
        // Enables foreign key constraints for this connection.
        // this needs to be set for every connection so always use this function to connect to db
        $pdo->exec("PRAGMA foreign_keys = ON;");
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
