<?php
    session_start();
    // if (!isset($_SESSION['login'])) {
    //     header('location: login.php');
    // }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View added products</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <header>
            <?php
                require('header.php');
            ?>
        </header>
        
        <main>
            <!-- Main's content -->
            <h1>LIST OF PRODUCTS</h1>

            <?php
                echo "<table class=\"products-table\">";
                    echo "<tr>";
                    // Headers
                    echo "<th> Name </td>";
                    echo "<th> Price (VND)</td>";
                    echo "<th> Description </td>";
                    echo "<th> Image </td>";

                    echo "</tr>";

                require_once("read_file.php");

                if (isset($_SESSION['items'])) {
                    $items = $_SESSION['items'];
                    foreach ($items as $item) {
                        if (strcmp($item['vendor'], 'Khoa') == 0) { // Change later $_SESSION['username']
                            echo "<tr>";
                            // Data
                            echo "<td>".$item['name']."</td>";
                            echo "<td>".$item['price']."</td>";
                            echo "<td>".$item['description']."</td>";
                            echo "<td><a href=".$item['image']." target=\"_blank\" rel=\"noreferrer noopener\"> View "."</a> </td>";

                            echo "</tr>";
                        }
                    }
                echo "</table>";
                }
            ?>
        </main>

        <footer>
            <?php
                require('footer.php');
            ?>
        </footer>
    </body>
</html>