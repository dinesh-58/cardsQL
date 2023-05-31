<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CardsQL| Add cards</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once './header.html'?>
        <form action="" method="">
            <label>
                Front:
            <textarea name="card-front" id="" maxlength="255" spellcheck="true" cols="30" rows="10" placeholder="Question. Example: What is CSS used for?" required autofocus></textarea>
            </label>
            <span>Card direction:</span>
            <!--? Can use arrow characters (not emoji) for these instead of text-->
            <input type="radio" name="card-direction" value="1" checked>Forward
            <input type="radio" name="card-direction" value="2">Backward
            <input type="radio" name="card-direction" value="3">Bi-directional
            <label>
                Back:
            <textarea name="card-back" id="" maxlength="255" spellcheck="true" cols="30" rows="10" placeholder="Answer. Example: Styling our HTML" required></textarea>
            </label>
            <button name="submit">Submit</button>
        </form> 

<?php 
if (isset($_GET['submit'])) {
    $front = $_GET['card-front'];
    $back = $_GET['card-back'];
    $direction = $_GET['card-direction'];

    $pdo = new PDO('sqlite:cardsql.db');
    
    // we only insert values specifiable by user. the rest all have default values set in the database schema
    $query = 'insert into cards(front, back, direction) values(?, ?, ?);';

    // prepare statement
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $front, PDO::PARAM_STR);
    $statement->bindValue(2, $back,  PDO::PARAM_STR);
    $statement->bindValue(3, $direction, PDO::PARAM_INT);

    if ($statement->execute()) {
        echo 'Card created!';}
/*
    // TODO create custom-functions.php file. displayMessage(success, message)  
        // if success, echo html div with green background & tick
        // else use red background & cross
    // after creating, replace the above echo statement with these 2 lines below
    
        displayMessage(true, 'Card created!');
    } else displayMessage(false, 'Error creating card');
*/
}
?>

    </body>
</html>

