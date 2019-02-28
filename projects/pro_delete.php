<?php
require_once '../common/database.php';

try {
        $dbh = getDb();

        $sql = <<<SQL
DELETE FROM projects WHERE pro_id=?
SQL;

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, PDO::PARAM_INT);
        $stmt->execute(array(
        $_GET['id']
        ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}

    header('Location: ./pro_list.php');
