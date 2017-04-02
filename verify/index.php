<?php
include_once '../php/connect.php';
if(isset($_GET['code']))
{
    $code=filter_input(INPUT_GET,'code',FILTER_SANITIZE_SPECIAL_CHARS);
    $query="SELECT `userid` FROM `user_info` WHERE `code`=:code LIMIT 1";
    try{
        $stmt=$conn->prepare($query);
        $stmt->execute(array(':code'=>$code));
        $result=$stmt->fetchAll();
    } catch (PDOException $e) {
        echo "ERROR:".$e->getMessage();
    }
    if(count($result))
    {
        $query="UPDATE `user_level` SET `verify`=1 WHERE `userid`=:id";
    try{
        $stmt=$conn->prepare($query);
        $stmt->execute(array(':id'=>$result[0]['userid']));
        //header('Location:../');
    } catch (PDOException $e) {
        echo "ERROR2:".$e->getMessage();
    }
 echo "<script>alert('You have successfully verified your account');window.location.assign('../');</script>";
    }
    else {
        echo "<script>alert('Wrong identification code');window.location.assign('../');</script>";
 }
}
?>

