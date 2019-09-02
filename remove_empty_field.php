<?php

$new = 'SELECT * FROM qualification';
$result=mysqli_query($db,$new);
while($row=mysqli_fetch_array($result))
{
    $a=$row['field'];
    $b=$row['serial'];
    if(empty($a))
    {
        $sql="DELETE FROM `qualification` WHERE serial='$b'";
        mysqli_query($db,$sql);
    }
}
$new = 'SELECT * FROM training';
$result=mysqli_query($db,$new);
while($row=mysqli_fetch_array($result))
{
    $a=$row['title'];
    $b=$row['serial'];
    if(empty($a))
    {
        $sql="DELETE FROM `training` WHERE serial='$b'";
        mysqli_query($db,$sql);
    }
}
$new = 'SELECT * FROM job_experience';
$result=mysqli_query($db,$new);
while($row=mysqli_fetch_array($result))
{
    $a=$row['previous_employer'];
    $b=$row['serial'];
    if(empty($a))
    {
        $sql="DELETE FROM `job_experience` WHERE serial='$b'";
        mysqli_query($db,$sql);
    }
}
$new = 'SELECT * FROM disciplinary';
$result=mysqli_query($db,$new);
while($row=mysqli_fetch_array($result))
{
    $a=$row['type'];
    $b=$row['serial'];
    if(empty($a))
    {
        $sql="DELETE FROM `disciplinary` WHERE `disciplinary`.`serial`='$b'";
        mysqli_query($db,$sql);
    }
}
$new = 'SELECT * FROM complain';
$result=mysqli_query($db,$new);
while($row=mysqli_fetch_array($result))
{
    $a=$row['remarks'];
    $b=$row['serial'];
    if(empty($a))
    {
        $sql="DELETE FROM `complain` WHERE serial='$b'";
        mysqli_query($db,$sql);
    }
}




?>