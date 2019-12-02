<?php
    include "connect.php";
    session_start();

    $user = $_POST["txtUser"];
    $pass = $_POST["txtPass"];

    $qry = "SELECT * FROM user WHERE user= '".$user."'";

    $res = $con->query($qry);

    $msg = "";
    if($res->num_rows > 0)
    {
        //user exists
        $row = $res->fetch_assoc();
        if($row["password"] == $pass)
        {
            $_SESSION["tuser"]="$user";
            header("Location:forum.html");
        }
        else
        {

            $msg = "Invalid password";
            header("Location:login.php?Message=$msg");
        }
    }
    else
    {
        $msg = "The Username: ".$user." does not exist!";
        header("Location:login.php?Message=$msg");
    }
?>
