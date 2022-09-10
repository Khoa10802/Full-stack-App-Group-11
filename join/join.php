<?php
    Define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
    require DOC_ROOT_PATH . "/common/common.php";
?>
<?php
    $pd = json_decode(file_get_contents('php://input'), true);
    $fr = fopen(DOC_ROOT_PATH . $PATH,"r");
    $db = array();
    if(!preg_match("/[^a-z0-9]/i", $pd["id"])) {
        $len = strlen($pd["id"]);
		if($len >= 8 && $len <= 15){
		} else {
			return "Your ID must have: only characters a-z and 0-9; 8-15 characters in length!";
		}
    }
    
    if($pd["pw"]){
        $pw = $pd["pw"];
        $num = preg_match('/[0-9]/u', $pw);
        $eng = preg_match('/[a-z]/u', $pw);
        $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);
        if(strlen($pw) < 10 || strlen($pw) > 30){
            exit;
            if(preg_match("/\s/u", $pw) == true){
                exit;
                if( $num == 0 || $eng == 0 || $spe == 0){
                    exit;
                }
            }
        }
    }

    while ($row=fgetcsv($fr)){
        $db[] = $row;
    }
    $pwd = password_hash($pd["pw"], PASSWORD_DEFAULT);

    $data = array(
        array($pd["id"], $pwd, $pd["pf"], $pd["name"], $pd["adr"], $pd["gubn"])
    );

    $fw = fopen(DOC_ROOT_PATH . $PATH, "w");

    foreach($db as $fields){
        fputcsv($fw, $fields);
    }

    foreach($data as $fields2){
        fputcsv($fw, $fields2);
    }

    fclose($fr);
    fclose($fw);

?>
