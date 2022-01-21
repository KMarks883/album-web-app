<?php 
session_start();

require("DBConnect.php");


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
        
    if(empty(trim($username)) and empty(trim($password)))	{
        echo "Please fill in the blank";
    }
    else{
        
        $output = mysqli_query($connection, "select * from users where username = '$username'");
        $countOutput = mysqli_num_rows($output);
        
        if($countOutput==1){
            
            $userinfo = mysqli_fetch_array($output);
            if($userinfo['password'] === $password){
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username; 
                $_SESSION['user_id'] = $userinfo['user_id']; 
                header("Location: DBProject_MainMenu.php");
                die();
            }
        }
        
        echo "Username/Password does not match. Try again! <br>";
        echo "<a href='DBProject_Login.html'>Go Back To Login Screen</a>";
    } 
}


?>