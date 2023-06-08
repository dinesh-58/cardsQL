<?php
// WARNING: currently this only keeps selecting the same card. 

require_once './header.html';
require_once './srs-algorithm.php';
$pdo = new PDO('sqlite:cardsql.db');
session_start(); 
if (isset($_GET['card-rating'])) {
    // update card values in DB
    // overwrite old values in session variable for last 4 columns in DB
    $_SESSION['prevCard'] = scheduleNextRevision($_SESSION['prevCard'], $_GET['card-rating']);
    $sqlUpdateCard = 'update cards
                      set
                        `successfulRevisions` = ?,
                        `easeFactor` = ?,
                        `interval` = ?,
                        `scheduledDate` = ?
                      where id = ?';
    $statementUpdate = $pdo->prepare($sqlUpdateCard);

    $statementUpdate->bindValue(1, $_SESSION['prevCard']['successfulRevisions']);
    $statementUpdate->bindValue(2, $_SESSION['prevCard']['easeFactor']);
    $statementUpdate->bindValue(3, $_SESSION['prevCard']['interval']);
    $statementUpdate->bindValue(4, $_SESSION['prevCard']['scheduledDate']);
    $statementUpdate->bindValue(5, $_SESSION['prevCard']['id']);
    $statementUpdate->execute();
} 

// 1st card?
$sqlSelectCard = 'select * from cards limit 1'; 
// $sqlSelectCard = 'select * from cards where scheduledDate >= CURRENT_DATE limit 1';
$statementSelect = $pdo->query($sqlSelectCard);
$currentCard = $statementSelect->fetch(PDO::FETCH_ASSOC); 
$_SESSION['prevCard'] = $currentCard;
if (!$currentCard) echo 'Congrats! You have reviewed all cards for today.';

// TODO delete these 4 lines later
echo '<pre>';
print_r($currentCard);
print_r($_SESSION['prevCard']);
echo '</pre>';

?>
<html lang="en">
    <head>
        <title>CardsQL| Review cards</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <form method="GET">
            <h3><?=$currentCard['front'] ?></h3>
            <button id="showAnswerBtn" type="button" onclick="showAnswer()">Show Answer</button>

            <div id="answer-container" class="hidden">
                <h4><?=$currentCard['back']?></h4>
                <span>How well did you remember?</span>
                <button name="card-rating" value="0">0 : Forgot</button>
                <button name="card-rating" value="1">1 : Partially remembered</button>
                <button name="card-rating" value="2">2 : Remembered after some effort</button>
                <button name="card-rating" value="3">3 : Remembered easily</button>
            </div>
        </form>

        <script type="text/javascript">
            function showAnswer() {
                document.querySelector('#showAnswerBtn').classList.add('hidden');
                document.querySelector('#answer-container').classList.remove('hidden');
            } 
        </script>
    </body>
</html>
