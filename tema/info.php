<?php
// require 'vendor/autoload.php'; 
// use PhpOffice\PhpSpreadsheet\Spreadsheet; 
// require_once('../libraries/PhpSpreadsheet/scr/PhpSpreadsheet/Spreadsheet.php');
// require_once('../libraries/PhpSpreadsheet/scr/PhpSpreadsheet/Writer/Xlsx.php');
// // use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
// $spreadsheet = new Spreadsheet(); 
// $sheet = $spreadsheet->getActiveSheet();
// $sheet->setCellValue('A1', 'Hello World !');

// $writer = new Xlsx($spreadsheet);
// $writer->save('hello world.xlsx');



require_once('../vendor/Psr/autoloader.php');
require_once('../PhpSpreadsheet/autoloader.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');