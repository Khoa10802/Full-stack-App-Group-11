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

    for ($i = 0; $i < count($_SESSION['shipments']); $i++) {
        $buffer1 = "deliver".$i;
        $buffer2 = "order".$i;
        $buffer3 = "cancel".$i;
        if ((isset($_POST[$buffer1]) || isset($_POST[$buffer3])) && isset($_POST[$buffer2])) {

            $temp_order = $_POST[$buffer2];
            if (!isset($_GET['hub_option']) && empty($_GET['hub_option'])) {
                $hub_number = 'hub1';
            }
            else $hub_number = $_GET['hub_option'];

            $temp = [];

            for ($i = 0, $k = 0; $i < count($_SESSION['shipments']); $i++) {
                if ($temp_order == $i) {
                    continue;
                }
                $temp[$k++] = $_SESSION['shipments'][$i];
            }
            $_SESSION['shipments'] = $temp;
            
            // echo "<pre>";
            // print_r($_SESSION['shipments']); 
            // echo "</pre>";

            $file_name = $mapping[$hub_number];
            $fp = fopen($file_name, 'w');
            $headers = ['name', 'address', 'customers', 'items', 'total', 'status'];
            fputcsv($fp, $headers);
            if (is_array($_SESSION['shipments'])) {
                foreach ($_SESSION['shipments'] as $order) {
                    $order['items'] = implode(',', $order['items']);
                    fputcsv($fp, $order);
                }
            }
            fclose($fp);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" type="text/css">
        <title>Shipper Page</title>
    </head>

    <body>
        <header>
            <?php
                require('header.php');
            ?>
        </header>

        <main>
            <!-- Main's content -->
            <h1>SHIPPING LIST</h1>
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

            <?php
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
                            echo "<div class=\"total\">Total: ";
                                echo $shipment['total']." VND";
                            echo "</div>";
                        echo "</div>";

                        // Buttons
                        echo "<div class=\"order_btn\">";
                            echo "<form method=\"post\" action=\"#\">";
                                echo "<input type=\"hidden\" name=\"order".$order_no."\" id=\"order\" value=\"".$order_no."\">";
                                echo "<div class=\"buttons\">";
                                    echo "<div class=\"deliver_btn\">";
                                        echo "<input type=\"submit\" value=\"Deliver\" name=\"deliver".$order_no."\" id=\"deliver_btn\">";
                                    echo "</div>";
                                    echo "<div class=\"cancel_btn\">";
                                        echo "<input type=\"submit\" value=\"Cancel\" name=\"cancel".$order_no."\" id=\"cancel_btn\">";
                                    echo "</div>";
                                echo "</div>"; 
                        echo "</div>";            

                        echo "</form>";
                    echo "</div>";
                            
                    $order_no++;
                }
            ?>
            <script>
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

        <footer>
            <?php
                require('footer.php');
            ?>
        </footer>
    </body>
</html>