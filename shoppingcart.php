<?php     
    declare(strict_types=1);
    session_start();

    function cal_total(array $cart_items) {
        require_once('read_file.php');
        $total = 0;
        foreach ($cart_items as $cart_item) {
            foreach ($items as $item) {
                if (strcmp($cart_item, $item['name']) == 0) {
                    $total += $item['price'];     
                }
            }
        }
        return $total;
    }

    function add2file(string $f_name, string $hub_name) {
        $file_name = $f_name;
        $fp = fopen($file_name, 'w');
        $headers = ['name', 'address', 'customers', 'items', 'total', 'status'];
        fputcsv($fp, $headers);
        if (is_array($_SESSION[$hub_name])) {
            foreach ($_SESSION[$hub_name] as $order) {
                $order['items'] = implode(',', $order['items']);
                fputcsv($fp, $order);
            }
        }
        fclose($fp);
    };

    if (isset($_GET['order_btn'])) {
        $random_hub = random_int(0, 2);
        // $random_hub = 0;

        if (isset($_GET['items'])) {
            if ($random_hub == 0) {
                $hub1 = [
                    'name' => "hub1",
                    'address' => "123",
                    'customer' => 'Khoa', // Change later
                    'items' => explode(',', $_GET['items']),
                    'total' => cal_total(explode(',', $_GET['items'])),
                    'status' => 'Active' // Initial State
                ];
                $_SESSION['hub1'][] = $hub1;
                add2file('allhubs/hub1.csv', 'hub1');
            }
            else if ($random_hub == 1) {
                $hub2 = [
                    'name' => "hub2",
                    'address' => "456",
                    'customer' => 'Khoa', // Change later
                    'items' => explode(',', $_GET['items']),
                    'total' => cal_total(explode(',', $_GET['items'])),
                    'status' => 'Active'
                ];
                $_SESSION['hub2'][] = $hub2;
                add2file('allhubs/hub2.csv','hub2');
            }
            else {
                $hub3 = [
                    'name' => "hub3",
                    'address' => "789",
                    'customer' => 'Khoa', // Change later
                    'items' => explode(',', $_GET['items']),
                    'total' => cal_total(explode(',', $_GET['items'])),
                    'status' => 'Active'
                ];
                $_SESSION['hub3'][] = $hub3;
                add2file('allhubs/hub3.csv', 'hub3');
            }
        }
    }
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
            <h1>SHOPPING CART</h1>
            <!-- UI NOTE: Most html is over in cart.js
                    |
                    V    -->
            <div class="cart"> 
            </div>

            <div class="order_btn">
                <input type="submit" value="Order" id="order_btn" name="order_btn" onclick="urlchange()">
            </div>
            
            <script src="cart.js"></script>
        </main>

        <footer>
            <?php
                require('footer.php');
            ?>
        </footer>
    </body>
</html>    