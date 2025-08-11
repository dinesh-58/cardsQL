<?php
// take card id, rating, then use srs-algo?
// basically replicate 1st bit of code in review.php
// TODO: test if this works

require_once "../bootstrap.php";
require_once BASE_DIR . "/srs-algorithm.php";
$pdo = connect_db();
header('Content-Type: text/plain');
session_start();  // NOTE: was copied from old code. prob unnecessary now

// this api route should probably be using POST & request body instead of query params but meh 
if (!isset($_POST["card-id"])) {
  http_response_code(400);
  exit("Error: Card id not specified");
}
if (!isset($_POST["card-rating"])) {
  http_response_code(400);
  exit("Error: Card rating not specified");
}
// user will rate their ability to remember it.
// we then schedule its next repitition

$stmtCurrCard = $pdo->prepare("select * from cards where id = ? limit 1");
$stmtCurrCard->bindValue(1, $_POST["card-id"], PDO::PARAM_INT);
$stmtCurrCard->execute();
$card = $stmtCurrCard->fetch(PDO::FETCH_ASSOC);

// overwrite old card w/ updated card data
$card = scheduleNextRevision($card, $_POST["card-rating"]);

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

// MAYBE: handle other HTTP statuses here too if error occurs
http_response_code(200);
echo 'Card rated successfully';