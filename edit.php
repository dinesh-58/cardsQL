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
        <table>
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Front</th>
                    <th scope="col">Back</th>
                    <th scope="col">Card Direction</th>
                    <th scope="col">Scheduled Date</th>
                </tr> 
            </thead>
            <?php
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <th scope="row"><?=$row['id']?></th>
                    <td><?=$row['front']?></td>
                    <td><?=$row['back']?></td>
                    <td><?php 
                        switch($row['direction']) {
                            case 0:
                                echo 'disabled';
                                break;
                            case 1:
                                echo 'forward';
                                break;
                            case 2:
                                echo 'backward';
                                break;
                            case 3:
                                echo 'bi-directional';
                                break;
                            default :
                                echo '<strong style="background:red;">Error: Invalid direction value</strong>';
                        }
                    ?></td>
                    <td><?=$row['scheduledDate']?></td>
                    <!-- TODO: edit button which onclick causes edit dialog to be shown -->
                </tr>
                <?php
            }
            ?>
        </table>
        <script src="./edit-logic.js"></script>
    </body>
</html>
