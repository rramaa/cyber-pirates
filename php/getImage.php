<?php
include_once 'connect.php';
if(isset($_SESSION['userlevel']) && isset($_SESSION['userid']) && isset($_SESSION['username']))
{
    $userid=$_SESSION['userid'];
    $userlevel=$_SESSION['userlevel'];
    $username=$_SESSION['username'];
    $query="SELECT `pic`,`filetype` FROM `question` WHERE `qnum`=:userlevel LIMIT 1";
    try{
        $stmt=$conn->prepare($query);
        $stmt->execute(array(':userlevel'=>$userlevel));
        $result=$stmt->fetchAll();
    } catch (PDOException $e) {
        echo "ERROR:".$e->getMessage();
    }
    if(count($result))
    {
        header("Content-type:image/".$result[0]['filetype']);
        echo $result[0]['pic'];
    }
}
else
{
    header("Location:../");
}
?>