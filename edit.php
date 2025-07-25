<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CardsQL| View / Edit cards</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once "./header.html"; ?>
        <?php
        $pdo = new PDO("sqlite:cardsql.db");
        if (isset($_POST["delete-card"])) {
            $resultDelete = $pdo->query(
                "delete from cards where id = {$_POST["id"]};",
            );
            echo $resultDelete ? "Card deleted" : "Error deleting card";
        } elseif (isset($_POST["edit-card"])) {
            $editQuery =
                "update cards set front=:front, back=:back, direction=:direction, scheduledDate=:date where id=:id";
            // $editQuery = 'update cards set front=":front", back=":back", direction=:direction, scheduledDate=":date" where id=:id';
            $statement = $pdo->prepare($editQuery);
            $statement->bindValue(
                ":front",
                $_POST["card-front"],
                PDO::PARAM_STR,
            );
            $statement->bindValue(":back", $_POST["card-back"], PDO::PARAM_STR);
            $statement->bindValue(
                ":direction",
                $_POST["card-direction"],
                PDO::PARAM_STR,
            );
            $statement->bindValue(
                ":date",
                $_POST["card-new-date"],
                PDO::PARAM_STR,
            );
            $statement->bindValue(":id", $_POST["id"], PDO::PARAM_INT);
            echo $statement->execute() ? "Card edited" : "Error editing card";
        }

        $sqlSelect =
            "select id, front, back, direction, scheduledDate from cards;";
        $resultSelect = $pdo->query($sqlSelect);
        ?>
        <h2>Click on the row you want to edit</h2>
        <table id="editable-cards-table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Front</th>
                    <th scope="col">Card Direction</th>
                    <th scope="col">Back</th>
                    <th scope="col">Scheduled Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultSelect->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <th scope="row"><?= $row["id"] ?></th>
                        <td><?= $row["front"] ?></td>
                        <td><?= $row["direction"] ?></td>
                        <td><?= $row["back"] ?></td>
                        <td><?= $row["scheduledDate"] ?></td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>

        <dialog id="edit-card-dialog">
            <form method="post">
                <fieldset>
                    <legend></legend>
                    <input type="hidden" name="id">
                    <label><span>Front:</span>
                        <textarea name="card-front" id="" maxlength="255" spellcheck="true" rows="10" placeholder="Question. Example: What is CSS used for?" required autofocus></textarea>
                    </label>
                    <label><span>Card Direction:</span>
                        <select name="card-direction">
                            <option value="disabled">Disabled</option>
                            <option value="forward">Forward</option>
                            <option value="backward">Backward</option>
                            <option value="both">Bi-directional</option>
                        </select>
                    </label>
                    <label><span>Back:</span>
                        <textarea name="card-back" id="" maxlength="255" spellcheck="true" rows="10" placeholder="Answer. Example: Styling our HTML" required></textarea>
                    </label>
                    <label><span>Scheduled Date:</span>
                        <input name="card-new-date" type="date">
                    </label>
                </fieldset>
                <button type="button" class="dialog-cancel">Cancel</button>
                <button type="submit" name="delete-card">Delete card</button>
                <button type="submit" name="edit-card">Confirm changes</button>
            </form>
        </dialog>

        <script src="./edit-logic.js"></script>
    </body>
</html>
