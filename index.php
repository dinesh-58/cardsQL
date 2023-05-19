<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CardsQL| Add cards</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <form action="" method="post">
            <!-- maxlength is specified to set limit for varchar in database table--> 
            <label>
                Front:
            <textarea name="card-front" id="" maxlength="280" spellcheck="true" cols="30" rows="10" placeholder="What is CSS used for?" required autofocus></textarea>
            </label>
            <span>Card direction:</span>
            <!--? Can use arrow characters (not emoji) for these instead of text-->
            <input type="radio" name="card-direction" value="forward" checked>Forward
            <input type="radio" name="card-direction" value="backward">Backward
            <input type="radio" name="card-direction" value="bi">Bi-directional
            <label>
                Back:
            <textarea name="card-back" id="" maxlength="280" spellcheck="true" cols="30" rows="10" placeholder="Styling our HTML" required></textarea>
            </label>
            <!--TODO use php for setting default attributes (review_date, EF, n)-->
            <button>Submit</button>
        </form> 

<?php 
echo "testing"
?>

    </body>
</html>

