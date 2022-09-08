<?php
$user = json_decode(file_get_contents('php://input'), true);

if($user["id"] == null) {
    $array = Array (
        "response" => "false",
    );
} else {
    $array = Array (
        "response" => "true",
    );
}
$json = json_encode($array);
echo $json; 
?>
