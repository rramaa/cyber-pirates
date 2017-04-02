<?php
    include_once 'config.php';
    try{
        $conn=new PDO(DATABASE_TYPE."host=".SERVER.";dbname=".DATABASE, USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "ERROR:".$e->getMessage();
    }
    session_start();
?>