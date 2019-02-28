<?php
require '../vendor/autoload.php';
require_once '../common/database.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('../xlsx_template/test01_template.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$sql = <<<SQL
  SELECT * FROM projects 
  WHERE co_id=6
  ORDER BY pro_id DESC;
SQL;
try {
    $dbh = getDb();
    $num = 2;

    $stmt = $dbh->query($sql);

    foreach ($stmt as $row) {
        $pro_id = $row['pro_id'];
        $pro_name = $row['pro_name'];
        $co_id = $row['co_id'];

        $sheet->setCellValue("A" . $num, $pro_id);
        $sheet->setCellValue("B" . $num, $pro_name);
        $sheet->setCellValue("F" . $num, $co_id);

        $num++;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $dbh = null;
}

$writer = new Xlsx($spreadsheet);
$writer->save('../xlsx_export/test01.xlsx');
header('Location: ../xlsx_export/download.php');
