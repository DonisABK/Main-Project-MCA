<?php

$filename=$POST['filename']

$target_directory ="files/";
$target_file = $target_directory.basename($_FILES["file"]["name"]);
$filetype = strtolower(pathinfo($target_file.PATHINFO_EXTENSION));
$newfilename = $target_directory.$filename.".".$filetype;

move_upload_file($FILES["file"]['top_name'].$nawfilename);

if(move_upload_files($_FILES["file"]["tmp_name"].$newfilename))
echo 1;
else
echo 0;
?>