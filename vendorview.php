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

            <a href="vendoradd.php">
                <!-- Temporary button -->
                <input type="submit" value="Add item" id="backtoadd_btn">
            </a>


                <table>
                    <tr>
                    <!-- Headers -->
                    <td> Name </td> 
                    <td> Price </td>
                    <td> Description </td>
                    <td> Image </td>

                    </tr>
            <?php
                require_once("read_file.php");
            
                if (isset($_SESSION['items'])) {
                    $items = $_SESSION['items'];
                    foreach ($items as $item) {
                        if (strcmp($item['vendor'], $_SESSION['username']) == 0) {
            ?>
                            <tr>
                                <!-- Data -->
                                <td> <?php $item['name'] ?> </td>
                                <td> <?php $item['price'] ?> </td>
                                <td> <?php $item['description'] ?> </td>
                                <td>
                                    <a href=" <?php $item['image'] ?>" target=_blank rel=noreferrer noopener> View </a> 
                                </td>";
                            </tr>
            <?php
                        }
                    }
                echo "</table>";
                }
            ?>
        </main>
    </body>
</html>