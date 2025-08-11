<?php
// take card id, rating, then use srs-algo?
// basically replicate 1st bit of code in review.php
// TODO: test if this works

require_once "../bootstrap.php";
require_once BASE_DIR . "/srs-algorithm.php";
$pdo = connect_db();
session_start();

if (!isset($_GET["card-rating"])) {
    exit("Error: Card rating not specified");
}
if (!isset($_GET["id"])) {
    exit("Error: Card id not specified");
}
// user will rate their ability to remember it.
// we then schedule its next repitition

$stmtCurrCard = $pdo->prepare("select * from cards where id = ? limit 1");
$stmtCurrCard->bindValue(1, $_POST["id"], PDO::PARAM_INT);
$stmtCurrCard->execute();
$card = $stmtCurrCard->fetch(PDO::FETCH_ASSOC);

echo "before rating: ";
print_r($card);
// overwrite old values in session variable for last 4 columns
$card = scheduleNextRevision($card, $_GET["card-rating"]);

echo "after rating: ";
print_r($card);

$sqlUpdateCard = 'update cards
                      set
                        `successfulRevisions` = ?,
                        `easeFactor` = ?,
                        `interval` = ?,
                        `scheduledDate` = ?
                      where id = ?';
$stmtUpdate = $pdo->prepare($sqlUpdateCard);

$stmtUpdate->bindValue(1, $card["successfulRevisions"], PDO::PARAM_INT);
// PARAM_STR used here cause no specific type for floats
$stmtUpdate->bindValue(2, $card["easeFactor"], PDO::PARAM_STR);
$stmtUpdate->bindValue(3, $card["interval"], PDO::PARAM_INT);
$stmtUpdate->bindValue(4, $card["scheduledDate"], PDO::PARAM_STR);
$stmtUpdate->bindValue(5, $card["id"], PDO::PARAM_INT);
$stmtUpdate->execute();

// MAYBE: return some succes message here?
