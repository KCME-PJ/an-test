<?php

require_once '../common/database.php';

$id = htmlspecialchars($_POST['id']);
$first =  htmlspecialchars($_POST['first']);
$last =  htmlspecialchars($_POST['last']);
$tel = htmlspecialchars(mb_convert_kana($_POST['tel'], "a"));
$email = htmlspecialchars(mb_convert_kana($_POST['email'], "a"));
$co_id = htmlspecialchars($_POST['co_id']);

$sql = <<<SQL
UPDATE members SET first_name=?, last_name=?, tel=?, email=?, co_id=? WHERE id=?
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $first_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $last_name, PDO::PARAM_STR);
    $stmt->bindValue(3, $tel, PDO::PARAM_STR);
    $stmt->bindValue(4, $email, PDO::PARAM_STR);
    $stmt->bindValue(5, $co_id, PDO::PARAM_INT);
    $stmt->bindValue(6, $id, PDO::PARAM_INT);
    
    $stmt->execute(array(
        $first,
        $last,
        $tel,
        $email,
        $co_id,
        $id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./users_list.php');
