<?php 
session_start(); 

include('database.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // mysql select and query select 
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $connectionDB->query($sql);

    if ($result->num_rows > 0) {
        // data fetch 
        $dataRow = $result->fetch_assoc();

        if ($dataRow['username'] == $username & $dataRow['password'] == $password) {
            $_SESSION['isAdmin'] = true;
            $_SESSION['name'] = $dataRow['username'];
            header("Location: index.php");
        } else {
            $_SESSION['loginFail'] = true;
            header("Location: login.php");
        }
    } else {
        $_SESSION['loginFail'] = true;
        header("Location: login.php");
    }  
}  else {
    header("Location: login.php");
}


















?>