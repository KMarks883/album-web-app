<!DOCTYPE HTML>
<html>
<body>
<?php 
	session_start();

	require("DBconnect.php");
    $goback = '<a href="DBProject_Delete.html">Go Back</a>';
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
		
			
			if($count == 0) {
				echo "<br>";
				echo "Username or Password is incorrect. Please try again.";
                echo $goback;
			}
			elseif(strlen($username) < 6 or strlen($password) < 6){
				echo "Username/Password needs to be 6 characters or longer!!!";
                echo $goback;
			}
		
			else{
				
				$query2 = "delete from users where username= '$username'";
				mysqli_query($connection, $query2);
				echo "You have permanently deleted your account: '{$username}' successfully! <br><br>";
				echo "Click <a href='DBProject_login.html'>here</a> to go to login page and make a new account.";
				die;
				
			}
		}
	}
?>

</body>
</html>