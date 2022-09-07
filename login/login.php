<?php include("../common/common.php");?>
<?php

$pd = json_decode(file_get_contents('php://input'), true);
$fr = fopen($PATH,"r");
$db = array();

while ($row=fgetcsv($fr)){
    $db[] = $row;
}
$response = "false";
foreach($db as $fields){
    if($fields["0"] === $pd["id"]) {
        if(password_verify($pd["pw"], $fields["1"])){
            if($fields["5"] === $pd["gubn"]){
                $response = "true";
            }
        }
    }
}

$array = Array (
    "response" => $response,
    "user" => $pd
);

$json = json_encode($array);
echo $json;
?>