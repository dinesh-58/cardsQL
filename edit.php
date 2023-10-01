<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CardsQL| Edit cards</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once './header.html'?>
        <?php
        $pdo = new PDO('sqlite:cardsql.db');
        $sql = 'select * from cards;';
        $result = $pdo->query($sql);

        ?>
        <h2>Click on the row you want to edit</h2>
        <table id="editable-cards-table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Front</th>
                    <th scope="col" class="tooltip-creator">
                        <span>Card Direction</span>
                        <span class="tooltip-question-mark">?</span>
                        <div class="tooltip-container">
                            <p>Meaning of values:</p>
                            <ul>
                                <li>0 = disabled</li>
                                <li>1 = forward</li>
                                <li>2 = backward</li>
                                <li>3 = bi-directional</li>
                            </ul>
                        </div>
                    </th>
                    <th scope="col">Back</th>
                    <th scope="col">Scheduled Date</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <th scope="row"><?=$row['id']?></th>
                        <td><?=$row['front']?></td>
                        <td><?=$row['direction'];?></td>
                        <td><?=$row['back']?></td>
                        <td><?=$row['scheduledDate']?></td>
                    </tr>
                    <?php
                }
                ?>
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
                            <option value="0">Disabled</option>
                            <option value="1">Forward</option>
                            <option value="2">Backward</option>
                            <option value="3">Bi-directional</option>
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
