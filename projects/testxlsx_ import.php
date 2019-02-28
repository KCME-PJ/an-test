<?php
require '../vendor/autoload.php';
require_once '../common/database.php';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load('project_importlist.xlsx');
$sheet = $spreadsheet->getSheetByName('list');

$sql = <<<SQL
INSERT INTO projects (pro_name,address,type_id,cus_id,co_id,sd,ed,flag)
VALUES (?,?,?,?,?,?,?,?)
SQL;

try {
    $dbh = getDb();
    $num = 2;
    $stmt = $dbh->prepare($sql);

    foreach ($sheet->getRowIterator() as $row) {
        $pro_name = $sheet->getCell("A" . $num);
        $add = $sheet->getCell("B" . $num);
        $type = $sheet->getCell("D" . $num)->getCalculatedValue();
        $cus = $sheet->getCell("F" . $num)->getCalculatedValue();
        $co = $sheet->getCell("H" . $num)->getCalculatedValue();
        $start_d = $sheet->getCell("I" . $num)->getFormattedValue();
        $end_d = $sheet->getCell("J" . $num)->getFormattedValue();
    
        $stmt->bindValue(1, $pro_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $add, PDO::PARAM_STR);
        $stmt->bindValue(3, $type, PDO::PARAM_INT);
        $stmt->bindValue(4, $cus, PDO::PARAM_INT);
        $stmt->bindValue(5, $co, PDO::PARAM_INT);
        $stmt->bindValue(6, $start_d, PDO::PARAM_STR);
        $stmt->bindValue(7, $end_d, PDO::PARAM_STR);
        $stmt->bindValue(8, 2, PDO::PARAM_STR);
        $stmt->execute();
        $num++;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $dbh = null;
}
// しっくりこないので、2次元配列を整理して作成し、バルクインサートする
