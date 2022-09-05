<?php
    // Filter settings
    if (isset($_GET['search_btn'])) {
        // Min+ | Max- | Name-
        if (!empty($_GET['min_price']) && empty($_GET['max_price']) && empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            foreach ($tmp as $item) {
                if ($item['price'] >= $_GET['min_price']) {
                    $items[] = $item;
                }
            }
        }
        // Min- | Max+ | Name-
        else if (empty($_GET['min_price']) && !empty($_GET['max_price']) && empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            foreach ($tmp as $item) {
                if ($item['price'] <= $_GET['max_price']) {
                    $items[] = $item;
                }
            }
        }
        // Min- | Max- | Name+
        else if (empty($_GET['min_price']) && empty($_GET['max_price']) && !empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            $keywork = "/".$_GET['input_name']."/i";
            foreach ($tmp as $item) {
                if (preg_match($keywork, $item['name']) == 1) {
                    $items[] = $item;
                }
            }
        }
        // Min+ | Max+ | Name+
        else if (!empty($_GET['min_price']) && !empty($_GET['max_price']) && !empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            $keywork = "/".$_GET['input_name']."/i";
            foreach ($tmp as $item) {
                if ($item['price'] >= $_GET['min_price'] && $item['price'] <= $_GET['max_price'] && preg_match($keywork, $item['name']) == 1) {
                    $items[] = $item;
                }
            }
        }
        // Min+ | Max+ | Name-
        else if (!empty($_GET['min_price']) && !empty($_GET['max_price']) && empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            foreach ($tmp as $item) {
                if ($item['price'] >= $_GET['min_price'] && $item['price'] <= $_GET['max_price']) {
                    $items[] = $item;
                }
            }
        }
        // Min+ | Max- | Name+
        else if (!empty($_GET['min_price']) && empty($_GET['max_price']) && !empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            $keywork = "/".$_GET['input_name']."/i";
            foreach ($tmp as $item) {
                if ($item['price'] >= $_GET['min_price'] && preg_match($keywork, $item['name']) == 1) {
                    $items[] = $item;
                }
            }
        }
        // Min- | Max+ | Name+
        else if (empty($_GET['min_price']) && !empty($_GET['max_price']) && !empty($_GET['input_name'])) {
            $tmp = $items;
            $items = [];
            $keywork = "/".$_GET['input_name']."/i";
            foreach ($tmp as $item) {
                if ($item['price'] <= $_GET['max_price'] && preg_match($keywork, $item['name']) == 1) {
                    $items[] = $item;
                }
            }
        }
    }
?>