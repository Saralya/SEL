<?php
$sql="SELECT * FROM login";
$result=mysqli_query($db,$sql); /*
while($row=mysqli_fetch_array($result))
{
    $username=$row['Username'];

    $query_1="SELECT * FROM department WHERE head_id='$username'";
    $res=mysqli_query($db,$query_1);
    if($res ->num_rows!=0)
    {
        $query="UPDATE login SET head='Yes' WHERE Username='$username'";
        mysqli_query($db, $query);
    }
    else
    {
        $query="UPDATE login SET head='No' WHERE Username='$username'";
        mysqli_query($db, $query);
    }
    $query_1="SELECT * FROM department WHERE reporter_id='$username'";
    $res=mysqli_query($db,$query_1);
    if($res ->num_rows!=0)
    {
        $query="UPDATE login SET reporter='Yes' WHERE Username='$username'";
        mysqli_query($db, $query);
    }
    else
    {
        $query="UPDATE login SET reporter='No' WHERE Username='$username'";
        mysqli_query($db, $query);
    }
}
*/

?>