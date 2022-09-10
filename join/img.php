<?php
$uploaded_file_name_tmp = $_FILES['file']['tmp_name'];
$uploaded_file_name = $_FILES['file']['name'];
$upload_folder = "../member/img/";
move_uploaded_file( $uploaded_file_name_tmp, $upload_folder . $uploaded_file_name );
$array = Array (
    "response" => $true,
);

$json = json_encode($array);
echo $json;
?>
