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
        <style>
            /* UI NOTE: This is temporary (but important), but you can alter it a bit and move them to dedicated css files */
            .order_collapsible {
                background-color: #777;
                color: white;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
            }
            .active, .order_collapsible:hover {
                background-color: #555;
            }

            .order_content {
                padding: 0 18px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.2s ease-out;
                background-color: #f1f1f1;
            }
        </style>
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
                    }
                }

                if (isset($_POST['deliver'])) {
                    if (!isset($_GET['hub_option']) && empty($_GET['hub_option'])) {
                        $hub_number = 'hub1';
                    }
                    else $hub_number = $_GET['hub_option'];

                    $count_order = 0;

                    $file_name = $mapping[$hub_number];
                    $fp = fopen($file_name, 'w');
                    $headers = ['name', 'address', 'customers', 'items', 'total', 'status'];
                    fputcsv($fp, $headers);
                    if (is_array($_SESSION['shipments'])) {
                        foreach ($_SESSION['shipments'] as $order) {
                            if ($count_order == $_POST['order']) {
                                $count_order++;
                                continue;
                            } 
                            $order['items'] = implode(',', $order['items']);
                            fputcsv($fp, $order);
                            $count_order++;
                        }
                    }
                    fclose($fp);
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
                    echo "<button type=\"button\" class=\"order_collapsible\"> Order ".($order_no+1)."</button>";
                    echo "<div class=\"order_content\">";
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
                        echo "<form method=\"post\" action=\"\">";
                            echo "<input type=\"hidden\" name=\"order\" id=\"order\" value=\"".$order_no."\">";
                            echo "<div class=\"buttons\">";
                                echo "<div class=\"deliver_btn\">";
                                    echo "<input type=\"submit\" value=\"Deliver\" name=\"deliver\" id=\"deliver_btn\">";
                                echo "</div>";
                                echo "<div class=\"cancel_btn\">";
                                    echo "<input type=\"submit\" value=\"Cancel\" name=\"cancel\" id=\"cancel_btn\">";
                                echo "</div>";
                            echo "</div>";
                        echo "</form>";
                    echo "</div>";
                    $order_no++;
                }
            ?>
            <script>
                let deliver = document.querySelector("#deliver_btn");
                let cancel = document.querySelector("#cancel_btn");
                let order = document.querySelector("#order");
                deliver.addEventListener('click', function() {
                    document.getElementsByTagName("form").setAttribute('action', location.href);
                    loaction.reload;
                })
                cancel.addEventListener('click', function() {
                    document.getElementsByTagName("form").setAttribute('action', location.href);
                    loaction.reload;
                })

                var coll = document.getElementsByClassName("order_collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.maxHeight){
                            content.style.maxHeight = null;
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    });
                    }
            </script>
        </main>
    </body>
</html>