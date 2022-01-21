<?php 
	session_start();

	require("DBconnect.php");
    $goback = '<a href="DBProject_SignUp.html">Go Back</a>';
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if(empty(trim($username)) and empty(trim($password))) {
			echo "Please enter some valid information!";
            echo $goback;
		}
		if(is_numeric($username)){
			echo "Username can't be numbers!";
            echo $goback;
		}
			
		else {
			$query1 = "select * from users where username= '$username'";
			$duplicateUsername = mysqli_query($connection, $query1);
			$count = mysqli_num_rows($duplicateUsername);
		
			
			if($count == 1) {
				echo "Username already existed!!!";
                echo $goback;
			}
			elseif($count <= 0 and strlen($username) < 6 or strlen($password) < 6){
				echo "Username/Password needs to be 6 characters or longer!!!";
                echo $goback;
			}
		
			else{
				
				$randomid = rand(10000,100000000);
				$query2 = "insert into users (user_id,username,password) values ('$randomid','$username','$password')";
			
				mysqli_query($connection, $query2);
				header("Location: DBProject_Login.html");
				die;
			}
		}
	}
?>