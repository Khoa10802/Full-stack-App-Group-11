<?php
    $file_name = "items.csv";
    $fp = fopen($file_name, 'w');
    $headers = ['name', 'price', 'description', 'image'];
    fputcsv($fp, $headers);
    if (is_array($_SESSION['items'])) {
        foreach ($_SESSION['items'] as $item) {
            // Add items to items.csv
            fputcsv($fp, $item);
        }
    }
    fclose($fp);  
?>