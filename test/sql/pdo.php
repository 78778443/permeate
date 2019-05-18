<?php


error_reporting(E_ALL);

$id = $_GET['id'];


try {
    $pdo = new PDO('mysql:dbname=permeate;host=db;port=3306;charset=utf8', 'root', '123');

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT * FROM bbs_user WHERE id = :id');
    $stmt->execute(array('id' => $id));


} catch (PDOException $e) {
    print "error" . $e->getMessage() . "</br>";
    die();
}


foreach ($stmt as $row) {
    $result[] = $row;
}

var_dump($result);
