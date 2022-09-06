<?php
error_log("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$");
error_log($_FILES["file"]["name"]);
error_log($_FILES["file"]["size"]);
error_log("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$");

function imgSave($path,$filename,$savefile) {
    $save_arr = explode(".",$savefile);

    if(is_file($path.$savefile)) $savefile = $save_arr[0]."_.".$save_arr[1];
    copy($filename,$path.$savefile);
    return $savefile;
}
?>