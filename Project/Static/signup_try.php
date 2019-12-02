<?php
    include "connect.php";

    $name=$_POST["txtName"];

    $email=$_POST["txtEmail"];
    $user = $_POST["txtUser"];
    $pass = $_POST["txtPass"];


    $qry = "INSERT INTO user VALUES ('".$user."','".$name."','".$email."','".$pass."')";

if ($con->query($qry)== TRUE)
{
   $msg="Successful ";

}
else
{
$msg = "Error! ";

}

header("Location:signup.php?Message=$msg");




?>
