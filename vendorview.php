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

        <!-- Sample table style (Need change) -->
        <style>
            table, td {
            border-width: 1px;
            border-style: solid;
            padding: 5px;
            }
        </style>
    </head>

    <body>
        <header>
            <!-- Header's content -->
        </header>
        
        <main>
            <!-- Main's content -->
            <h1>
                LIST OF PRODUCTS
            </h1>

            <?php
                echo "<table>";
                    echo "<tr>";
                    // Headers
                    echo "<td> Name </td>";
                    echo "<td> Price </td>";
                    echo "<td> Description </td>";
                    echo "<td> Image </td>";

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
                            echo "<td><a href=".$item['image']."> View "."</a> </td>";

                            echo "</tr>";
                        }
                    }
                echo "</table>";
                }
            ?>
        </main>
    </body>
</html>