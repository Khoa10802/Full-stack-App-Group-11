<?php
    Define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
    require DOC_ROOT_PATH . "/common/common.php";
?>
<?php

$pd = json_decode(file_get_contents('php://input'), true);
$fr = fopen(DOC_ROOT_PATH . $PATH,"r");
$db = array();

while ($row=fgetcsv($fr)){
    $db[] = $row;
}

$response = "false";
foreach($db as $fields){
    if($fields["0"] === $pd["id"]) {
        $id = $fields["0"];
        if(password_verify($pd["pw"], $fields["1"])){
            if($fields["5"] === $pd["gubn"]){
                $img = $fields["2"];
                $name = $fields["3"];
                $adr = $fields["4"];
                $gbn = $fields["5"];
                $response = "true";
            }
        }
    }
}

if($gbn){
    $array = Array (
        "response" => $response,
        "id" => $id,
        "img" => $img,
        "name" => $name,
        "adr" => $adr,
        "gbn" => $gbn,
    );
} else {
    $array = Array (
        "response" => $response,
    );
}

$json = json_encode($array);
echo $json;
?>
