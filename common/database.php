<?php
function getDb()
{
    $dsn = 'mysql:dbname=anzen; host=localhost; charset=utf8';
    $user = 'root';
    $password = 'anzen';
    $option = array (
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_PERSISTENT => true
    );
        $dbh = new PDO($dsn, $user, $password, $option);
    return $dbh;
}
