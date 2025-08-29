<?php
// gets multiple cards that should be reviewed today
// can specify these in queryParams?
// - limit: number of cards to get
// - folderId: folder to get cards from. 
// if both not specified, return 10 cards from all folders

require_once "../bootstrap.php";
require_once BASE_DIR . "/srs-algorithm.php";
$pdo = connect_db();
header('Content-Type: application/json');

// TODO: prob should implement type checking here
$limit = $_GET['limit'] ?? 10;
// if $folderId is not specified / null, get cards from all folders
$folderId = $_GET['folderId'] ?? null;

$sqlSelectCard = "select * from cards where scheduledDate <= CURRENT_DATE and direction <> 'disabled' ";
if ($folderId) {
	$sqlSelectCard .= "and folder_id = :folderId ";
}
$sqlSelectCard .="limit :limit";

$stmtSelectCard = $pdo->prepare($sqlSelectCard);
if ($folderId) $stmtSelectCard->bindValue(':folderId', $folderId, PDO::PARAM_STR);
$stmtSelectCard->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmtSelectCard->execute();
// TODO: prob should handle potential error cases here
$rows = $stmtSelectCard->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);