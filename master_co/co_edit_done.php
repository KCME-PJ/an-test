<?php
require_once '../common/database.php';

$co_id = htmlspecialchars($_POST['id']);
$co_name =  htmlspecialchars($_POST['co_name']);
$phone = htmlspecialchars(mb_convert_kana($_POST['tel'], "a"));
$co_url = htmlspecialchars(mb_convert_kana($_POST['co_url'], "as"));

$sql = <<<SQL
UPDATE companies SET co_name=?, phone=?, co_url=? WHERE co_id=?
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $co_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $phone, PDO::PARAM_STR);
    $stmt->bindValue(3, $co_url, PDO::PARAM_STR);
    $stmt->bindValue(4, $co_id, PDO::PARAM_INT);
    
    $stmt->execute(array(
        $co_name,
        $phone,
        $co_url,
        $co_id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./co_list.php');
