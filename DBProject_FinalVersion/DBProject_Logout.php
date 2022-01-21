<?php

session_start();

	if(session_destroy()) {
		header("Location: DBProject_Login.html");
	die;
	}
	
?>