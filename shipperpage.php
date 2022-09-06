<?php
    declare(strict_types=1);
    session_start();

    if (!file_exists("allhubs/hub1.csv")) {
        $fp = fopen("allhubs/hub1.csv", 'w');
        fclose($fp);

    }
    if (!file_exists("allhubs/hub2.csv")) {
        $fp = fopen("allhubs/hub2.csv", 'w');
        fclose($fp);
    }
    if (!file_exists("allhubs/hub3.csv")) {
        $fp = fopen("allhubs/hub3.csv", 'w');
        fclose($fp);
    }

    $_SESSION['shipment'] = [];
    function readhub(string $f_name) {
        if (file_exists($f_name)) {
            $file = $f_name;
            $fp = fopen($file, 'r');
            $headers = fgetcsv($fp);
            $orders = [];
            while ($row = fgetcsv($fp)) {
                $i = 0;
                $order = [];
                foreach ($headers as $col_name) {
                    $order[$col_name] = $row[$i];
                    if ($col_name == 'items') {
                        $order[$col_name] = explode(',', $order[$col_name]);
                    }
                    $i++;
                }
                $orders[] = $order;
            }
            $_SESSION['shipments'] = $orders;
            fclose($fp);
        }
    }

    require_once('read_file.php');

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shipper Page</title>
    </head>

    <body>
        <header>
            <!-- Header's content -->
            <div class="dropdown_menu">
                <select id="hub_option" name="hub_option">
                    <option value=""> Change Hub </option>
                    <option value="hub1"> Hub 1 </option>
                    <option value="hub2"> Hub 2 </option>
                    <option value="hub3"> Hub 3 </option>
                </select> 
            </div>
            <script>
                let select_hub = document.querySelector("#hub_option");
                select_hub.addEventListener('change', function() {
                    let hub_option = select_hub.value; 
                    location.href = "/shipperpage.php?hub_option=" + hub_option;
                })
                function deliver(deliver_no) {
                    location.href += "&deliver=" + deliver_no;
                    // location.href = "/shipperpage.php";
                }
                
            </script>  
        </header>
        <main>
            <!-- Main's content -->
            <?php

                $mapping = [
                    'hub1' => "allhubs/hub1.csv",
                    'hub2' => "allhubs/hub2.csv",
                    'hub3' => "allhubs/hub3.csv"
                ];

                $default_hub = "hub1";
                readhub($mapping[$default_hub]);

                if (isset($_GET['hub_option']) && !empty($_GET['hub_option'])) {
                    if (array_key_exists($_GET['hub_option'], $mapping)) {
                        readhub($mapping[$_GET['hub_option']]);
                        // echo "<h2> WORK </h2>";
                    }
                }

                if (isset($_GET['deliver']) && !empty($_GET['deliver'])) {
                    echo "<h1> WORK </h1>";
                }

                $order_no = 0;
                foreach ($_SESSION['shipments'] as $shipment) {
                    $quantity = [];
                    for ($i = 0; $i < count($shipment['items']); $i++) {
                        if (array_key_exists($shipment['items'][$i], $quantity)) {
                            $quantity[$shipment['items'][$i]] += 1;
                        }  
                        else {
                            $quantity[$shipment['items'][$i]] = 1;
                        }
                    }
                    echo "<h2> Order ".($order_no+1)."</h2>";
                    echo "<div class=\"order\">";
                        // Customers Info
                        echo "<div class=\"customer_info\">";
                            // Name
                            echo "<div class=\"customer_name\">";
                            echo "</div>";
                            // Address
                            echo "<div class=\"customer_address\">";
                            echo "</div>";
                        echo "</div>";
                        // Order Info
                        echo "<div class=\"order_info\">";
                            // Items
                            echo "<div class=\"items\">";
                                echo "<ul>";
                                foreach ($quantity as $itm => $amount) {
                                    echo "<li>".$itm." x ".$amount;
                                }
                                echo "</ul>";
                            echo "</div>";
        
                            // Total Amount
                            echo "<div class=\"total\">";
                                echo $shipment['total']." VND";
                            echo "</div>";
                        echo "</div>";

                        // Buttons
                        echo "<div class=\"buttons\">";
                            echo "<div class=\"deliver_btn\">";
                                echo "<input type=\"submit\" value=\"Deliver\" name=\"deliver\" id=\"deliver_btn\" onclick=\"deliver(".$order_no.")\">";
                            echo "</div>";
                            echo "<div class=\"cancel_btn\">";
                                echo "<input type=\"submit\" value=\"Cancel\" name=\"cancel\" id=\"cancel_btn\">";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    $order_no++;
                }
            ?>
        </main>
    </body>
</html>