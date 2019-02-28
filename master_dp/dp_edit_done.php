<?php

require_once '../common/database.php';

$id = htmlspecialchars($_POST['id']);
$name =  htmlspecialchars($_POST['name']);
$code_a = htmlspecialchars(mb_convert_kana($_POST['code'], "a"));
$code = strtoupper($code_a);

$sql = <<<SQL
UPDATE department SET name=?, code=? WHERE id=?
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->bindValue(2, $code, PDO::PARAM_STR);
    $stmt->bindValue(3, $id, PDO::PARAM_INT);
    
    $stmt->execute(array(
        $name,
        $code,
        $id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./dp_list.php');
