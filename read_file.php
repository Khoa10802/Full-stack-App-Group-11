<?php
    // Read items.csv to overwrite $_SESSION
    $file_name = "items/items.csv";
    $fp = fopen($file_name, 'r');
    $headers = fgetcsv($fp);
    $items = [];
    while ($row = fgetcsv($fp)) {
        $i = 0;
        $item = [];
        foreach ($headers as $col_name) {
            $item[$col_name] = $row[$i];
            $i++;
        }
        $items[] = $item;
    }
    // Overwrite
    $_SESSION['items'] = $items;
    fclose($fp);
?>