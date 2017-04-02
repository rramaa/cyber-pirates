<?php
include_once '../php/connect.php';
if(isset($_SESSION['userlevel']) && isset($_SESSION['username']) && isset($_SESSION['userid']))
{
    $userlevel=$_SESSION['userlevel'];
    try{
        $query="SELECT `url` FROM `question` WHERE `qnum`=:qnum LIMIT 1";
        $stmt=$conn->prepare($query);
        $stmt->execute(array(':qnum'=>$userlevel));
        $result=$stmt->fetchAll();
        if(count($result))
        {
            $url=$result[0]['url'];
        }
    } catch (PDOException $e) {
        echo "ERROR:".$e->getMessage();
    }
    header('Location:../question/?url_hint='.$url);
}
 else {
    header("Location:../");
}