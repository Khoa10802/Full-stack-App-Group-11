<?php include("../common/common.php");?>
<?php

    $pd = json_decode(file_get_contents('php://input'), true);
    $fr = fopen($PATH,"r");
    $db = array();

    while ($row=fgetcsv($fr)){
        $db[] = $row;
    }

    $data = array(
        array($pd["id"], $pd["pw"], $pd["pf"], $pd["name"], $pd["adr"], $pd["gubn"])
    );

    $fw = fopen($PATH, "w");

    foreach($db as $fields){
        fputcsv($fw, $fields);
    }

    foreach($data as $fields2){
        fputcsv($fw, $fields2);
    }

    fclose($fr);
    fclose($fw);

?>