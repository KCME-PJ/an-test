<?php
$file_name = 'test01.xlsx';
$f_size = filesize($file_name);

header('Content-Type: application/force-download;');
header("Content-Length: $f_size");
header("Content-Disposition: attachment; filename =$file_name");

readfile($file_name);
