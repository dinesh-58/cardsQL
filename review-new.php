<?php

require_once "./bootstrap.php";
require_once "./srs-algorithm.php";
$pdo = new PDO("sqlite:cardsql.db");
session_start();

// TODO: start -- replace this w/ api/getCards.php & some other code

// get next card (considered as 1st card if page is loaded for the 1st time)
$sqlSelectCard =
    "select * from cards where scheduledDate <= CURRENT_DATE and direction <> 'disabled'  limit 1";
$statementSelect = $pdo->query($sqlSelectCard);
$currentCard = $statementSelect->fetch(PDO::FETCH_ASSOC);
$_SESSION["prevCard"] = $currentCard;
$questionText = $answerText = "";
if (!$currentCard) {
    // TODO: maybe show this at center of screen instead
    echo "Congrats! You have reviewed all cards for today.";
} else {
    switch ($currentCard["direction"]) {
        case "forward":
            $questionText = $currentCard["front"];
            $answerText = $currentCard["back"];
            break;
        case "backward":
            $questionText = $currentCard["back"];
            $answerText = $currentCard["front"];
            break;
        case "both":
            // randomly use either front or back as question
            if (rand(0, 1)) {
                $questionText = $currentCard["front"];
                $answerText = $currentCard["back"];
            } else {
                $questionText = $currentCard["back"];
                $answerText = $currentCard["front"];
            }
            break;
        default:
            throw new Exception(
                "Invalid card direction value '{$currentCard["direction"]}' for card with id {$currentCard["id"]}. Please edit it in the edit page.",
            );
    }
}
// TODO: start -- replace this w/ api/getCards.php
?>

<html lang="en">

<head>
    <title>CardsQL| Review cards</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <?php require_once "./header.html"; ?>
    <form id="reviewCardForm" method="POST" action="<?= BASE_URL . "/api/postCardRating.php" ?>">
        <!-- <form method="GET"> -->
        <h3><?= $questionText ?></h3>
        <input type="hidden" name="card-id" value="<?= $currentCard["id"] ?>">
        <button id="showAnswerBtn" type="button" onclick="showAnswer()">Show Answer</button>
        <!-- NOTE: type for above button is "button" so that it doesn't submit form data.
               * however, below buttons should submit form data i.e. card rating -->

        <div id="answer-container" class="hidden">
            <h4><?= $answerText ?></h4>
            <span>How hard was it to remember the answer?</span>
            <button name="card-rating" value="0">0 : Forgot</button>
            <button name="card-rating" value="1">1 : Remembered incompletely</button>
            <button name="card-rating" value="2">2 : Required some effort</button>
            <button name="card-rating" value="3">3 : Easy to remember</button>
        </div>
    </form>

    <script type="text/javascript">
        // Browsers will auto-create JS objects for elements with ids
        reviewCardForm.onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(reviewCardForm);
            // formData doesn't include button value (card-rating), so manually add it
            if (e.submitter && e.submitter.name == "card-rating") {
                formData.append(e.submitter.name, e.submitter.value);
                fetch(reviewCardForm.action, {
                    method: reviewCardForm.method,
                    body: formData
                }).then(res => {
                    console.log(res);
                    // if(res.ok)  // show next card
                    return res.text();
                }).then(msg => {
                    console.log(msg);
                }).catch(error => {
                    alert('Error: ', error);
                });
            } else {
                alert('Form submitted w/o using proper button')
            }
        }

        function showAnswer() {
            document.querySelector('#showAnswerBtn').classList.add('hidden');
            document.querySelector('#answer-container').classList.remove('hidden');
        }
    </script>
</body>

</html>
