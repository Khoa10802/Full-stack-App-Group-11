<?php
    session_start();
    // if (!isset($_SESSION['login'])) {
    //     header('location: login.php');
    // }

    require_once("read_file.php");

    // Default setting
    if (isset($_SESSION['items'])) {
        $items = $_SESSION['items'];
    }
    else $items = [];

    // Filter settings
    if (isset($_GET['search_btn'])) {
        $tmp = $items;
        $items = [];
        foreach ($tmp as $item) {
            if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
                if ($item['price'] < $_GET['min_price']) {
                    continue;
                }
            }
            if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
                if ($item['price'] > $_GET['max_price']) {
                    continue;
                }
            }
            if (isset($_GET['input_name']) && !empty($_GET['input_name'])) {
                $keywork = "/".$_GET['input_name']."/i";
                if (preg_match($keywork, $item['name']) != 1) {
                    continue;
                }
            }
            $items[] = $item;
        }
        $_SESSION['items'] = $items;
    }
?>

<!-- REFERENCES:
https://www.freecodecamp.org/news/how-to-use-html-to-open-link-in-new-tab/
https://www.w3schools.com/php/
https://www.w3schools.com/html/ 
https://clipground.com/online-shopping-cart-icon-clipart.html -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers view products</title>
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
            <h1>Search</h1>
            <div class="search-bar">
                <form method="get" action="customerview.php">
                    <div class="price_search">
                        <div class="price_search_label">
                            <label> Price Search </label>
                        </div>
                        <input type="number" id="min_price" name="min_price" placeholder="Minimum"> -
                        <input type="number" id="max_price" name="max_price" placeholder="Maximum">
                    </div>
                
                    <div class="name_search">
                        <div class="name_search_label">
                            <label> Name Search </label>
                        </div>
                        <input type="text" id="input_name" name="input_name">
                    </div>

                    <div class="search_btn">
                        <input type="submit" value="Search" name="search_btn">
                    </div>
                </form>
                <script src="cart.js"></script>

                <!--<a href="shoppingcart.php">
                     UI NOTE: shopping cart icon resolution here, delete if use CSS 
                    <img src="items/images/cart-icon.png" alt="Image missing" width="50" height="50"> 
                </a>-->
            </div>

            <h1>Products list</h1>
            <div class="items-list">
                <?php
                    if (isset($_SESSION['items'])) {
                        foreach ($_SESSION['items'] as $item) {
                        echo "<div class=\"items\">"; // <--- UI NOTE: Flex this can add more DIV
                            echo "<a href=\"".str_replace(' ', '_', $item['name']).".php"."\">";
                                echo "<div class=\"item_container\">";
                                    // Image
                                    echo "<div class=\"item_image\">";
                                        echo "<img class=\"item_img\" src=".$item['image']." alt=\"Image Missing\">"; 
                                    echo "</div>";
                    
                                    echo "<div class=\"item_details\">";
                                        // Name
                                        echo "<div class=\"item_name\">";
                                            echo "<p class=\"item_name\">Product name: ".$item['name']."</p>";
                                        echo "</div>";
                        
                                        // Price
                                        echo "<div class=\"item_price\">";
                                            echo "<p class=\"item_price\">Price: ".$item['price']." VND</p>";
                                        echo "</div>";
                                    echo "</div>";

                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
                        }
                    }
                ?>
            </div>
        </main>

        <footer>
            <?php
                require('footer.php');
            ?>
        </footer>
    </body>
</html>