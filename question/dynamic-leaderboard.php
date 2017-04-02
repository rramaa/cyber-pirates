<?php
include_once '../php/connect.php';
$query="SELECT `level`,`teamname` from `user_level` ORDER BY `level` DESC, `time` ASC";
try{
$stmt=$conn->prepare($query);
$stmt->execute(array());
$result=$stmt->fetchAll();
}  catch (PDOException $e){
    echo "ERROR:".$e->getMessage();
}
$username=$_GET['username'];

$store=array();
$rank=1;
$flag=0;
if(count($result))
{
    foreach ($result as $row)
    {
        $store[$rank]="<tr><td>$rank</td><td>".$row['teamname']."</td><td>".$row['level']."</td></tr>";
        if($row['teamname']==$username)
        {
            $store[$rank]="<tr style='background-color:yellow;'><td>$rank</td><td>".$row['teamname']."</td><td>".$row['level']."</td></tr>";
            $flag=$rank;
        }
        $rank++;
    }
}
$total=count($result);
echo $store[1];
echo $store[2];
echo $store[3];
echo "<tr><th style='background-color:black;' colspan='3'></th></tr>";
if($flag==2)
{
    echo $store[4];
}
else if($flag==3)
{
    echo $store[4];
    echo $store[5];
}
else if($flag==4)
{
    echo $store[4];
    echo $store[5];
    echo $store[6];
}
else if($flag==5)
{
    echo $store[4];
    echo $store[5];
    echo $store[6];
    echo $store[7];
}
else if($flag>5){
    if(isset($store[$flag-2])) echo $store[$flag-2];
    if(isset($store[$flag-1])) echo $store[$flag-1];
    if(isset($store[$flag])) echo $store[$flag];
    if(isset($store[$flag+1])) echo $store[$flag+1];
    if(isset($store[$flag+2])) echo $store[$flag+2];
}
echo "<tr style='background-color:grey;font-weight:bold;'><td colspan='4'><a target='_blank' href='../leaderboard/'>Click Here to view the entire leaderboard</a></td></tr>";