<?php
require_once "./Formatter.class.php";

$input_file_name = "./../test-files/input1.txt";
$input_handle = fopen($input_file_name, "r");
$input_contents = fread($input_handle, filesize($input_file_name));
fclose($input_handle);

$formatter = new Formatter($input_contents);
$formatter->format();


