<?php
    $item_name = str_replace('_', ' ', basename($_SERVER['SCRIPT_FILENAME'], ".php"));

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $item_name?></title>
    </head>

    <body>
        <header>

        </header>
        <main>
            <?php 
                $file_name = "items/items.csv";
                $fp = fopen($file_name, 'r');
                $headers = fgetcsv($fp);
                $items = [];
                while ($row = fgetcsv($fp)) {
                    $i = 0;
                    $item = [];
                    if (strcmp($row[$i], $item_name) == 0) {
                        foreach ($headers as $col_name) {
                            $item[$col_name] = $row[$i];                     
                            $i++;
                        }
                        break;                     
                    }
                }
                fclose($fp);

                echo "<div class=\"preview_image\">";
                    echo "<a href=".substr($item['image'], 6)." target=\"_blank\" rel=\"noreferrer noopener\">";
                        echo "<img src=\"".substr($item['image'], 6)."\" alt=\"Image Missing\">";
                    echo "</a>";
                echo "</div>";

                echo "<div class=\"item_name\">";
                    echo "<p>".$item['name']."</p>";
                echo "</div>";

                echo "<div class=\"item_price\">";
                    echo "<p>".$item['price']."</p>";
                echo "</div>";

                echo "<div class=\"item_description\">";
                    echo "<p>".$item['description']."</p>";
                echo "</div>";

                // echo "<div class=\"item_vendor\">";
                //     echo "<p>".$item['vendor']."</p>";
                // echo "</div>";

                echo "<div class=\"add2cart_button\">";
                    echo "<input type=\"submit\" value=\"Add to cart\" id=\"add2cart_btn\" name=\"add2cart_btn\" 
                        onclick=\"add2cart('".$item["name"]."','".$item["price"]."','".$item["description"]."','".substr($item['image'], 6)."')\">";
                echo "</div>";
            ?>
        </main>
        <script src="cart.js"></script>
    </body>
</html>